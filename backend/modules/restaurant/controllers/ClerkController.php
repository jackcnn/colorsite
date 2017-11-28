<?php

namespace backend\modules\restaurant\controllers;

use common\models\Printer;
use common\models\Stores;
use Yii;
use common\models\Clerk;
use common\models\search\ClerkSearch;
use yii\web\NotFoundHttpException;

use backend\controllers\BaseController;
use yii\helpers\ColorHelper;
use yii\helpers\FileHelper;


class ClerkController extends BaseController
{

    public function actionIndex()
    {
        $searchModel = new ClerkSearch();
        $params = Yii::$app->request->queryParams;
        $params['ClerkSearch']['ownerid'] = $this->ownerid;
        $params['ClerkSearch']['store_id'] = \Yii::$app->request->get("store_id");

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'storeName' => $this->findStore($params['ClerkSearch']['store_id'])
        ]);
    }

    public function actionCreate()
    {
        $model = new Clerk();

        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->ownerid = $this->ownerid;
            $model->token = $this->token;
            $model->store_id = $request->get("store_id");
            $postData = $request->post("Clerk");

            $model->rights = json_encode($postData['rights']);

            if($model->validate() && $model->save()){
                ColorHelper::alert('新增店员成功！');
                return $this->redirect(['index','store_id'=>$request->get("store_id")]);
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }
        $model->loadDefaultValues();
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());

            $postData = $request->post("Clerk");

            $model->rights = json_encode($postData['rights']);


            if($model->validate() && $model->save()){
                ColorHelper::alert('修改店员'.$model->name.'成功！');
                return $this->redirect(['index','store_id'=>$model->store_id]);
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }
        return $this->render('update', [
            'model' => $model,
            'storeName'=> $this->findStore($model->store_id)
        ]);
    }

    //小程序绑定
    public function actionBind($id,$store_id)
    {
        return $this->render('bind',['id'=>$id,'store_id'=>$store_id,'token'=>$this->token]);
    }

    //公众号绑定 -- 去掉了的
    public function actionBindPublic($id,$store_id)
    {

        return $this->render('bind-public',['id'=>$id,'store_id'=>$store_id,'token'=>$this->token]);
    }

    //显示绑定二维码
    public function actionUnbind($id,$store_id){
        $model = Clerk::findOne($id);

        if($model){
            $model->openid = null;
            $model->wxname = null;
            $model->avatar = null;
            $model->public_openid = null;
            $model->receive = 0;

            $model->save();

        }
        return $this->redirect(['clerk/index','store_id'=>$store_id]);

    }

    //打印机打印二维码
    public function actionPrintQrcode($id,$store_id)
    {

        $printers = Printer::find()->where(['store_id'=>$store_id,'isuse'=>1])->asArray()->all();
        $count = 0;
        foreach($printers as $key=>$value){
            $actions = json_decode($value['actions'],1);
            if(in_array("qrcode",$actions)){//选为打印的，开始打印
               $count++;
            }
        }
        if($count<1){
            ColorHelper::err('没有对应的打印机！');
            return $this->redirect(['index','store_id'=>$store_id]);
        }

        $clerk = Clerk::findOne($id);
        $store = Stores::findOne($store_id);
        //二维码链接  https://colorsite.com/wxapp/dish?stid=1-2-BIND
        $str = \yii\helpers\Url::to(['/wxapp/dish','stid'=>$store_id.'-'.$id.'-BIND'],'https');
        $str = str_replace("/admin","",$str);

        $content = '';                          //打印内容
        $content .= '<center>'.$store->name.'</center>';
        $content .= '<center>绑定店员名称：'.$clerk->name.'</center>';
        $content .= "<center>（使用微信扫一扫二维码进行绑定）</center>\r\n";
        $content .= '<QR>'.$str.'</QR>';
        $content .= str_repeat('-',32)."\n";
        $content .= "<FS>扫码完成后请销毁二维码</FS>";

        $result = true;
        foreach($printers as $key=>$value){
            $actions = json_decode($value['actions'],1);
            if(in_array("qrcode",$actions)){//选为打印的，开始打印
                $machineCode = $value['machine_code'];                      //授权的终端号
                $res = \common\vendor\yilianyun\YilianyunHelper::printer($content,$machineCode);
                if($res == 'success'){
                    $result = true;
                }else{
                    ColorHelper::err('打印出错了！');
                    return $this->redirect(['index','store_id'=>$store_id]);
                }
            }
        }
        ColorHelper::alert('已打印');
        return $this->redirect(['index','store_id'=>$store_id]);

    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Clerk::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findStore($store_id)
    {
        $data = Stores::find()->where(['id'=>$store_id,'ownerid'=>$this->ownerid])->asArray()->one();
        return $data['name'];
    }
}
