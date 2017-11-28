<?php

namespace backend\modules\restaurant\controllers;

use common\models\Dishcart;
use common\models\Dishorder;
use common\models\Printer;
use common\models\Stores;
use DoctrineTest\InstantiatorTestAsset\FinalExceptionAsset;
use Yii;
use common\models\Dishtable;
use common\models\search\DishtableSearch;
use yii\helpers\CurlHelper;
use yii\helpers\FileHelper;
use yii\helpers\UHelper;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\controllers\BaseController;
use yii\helpers\ColorHelper;

class DishtableController extends BaseController
{


    public function actionIndex($storeid)
    {
        $searchModel = new DishtableSearch();
        $params = Yii::$app->request->queryParams;
        $params['DishtableSearch']['ownerid'] = $this->ownerid;
        $params['DishtableSearch']['store_id'] = $storeid;
        $dataProvider = $searchModel->search($params);

        $store = Stores::findOne($storeid);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'store'=>$store
        ]);
    }


    public function actionCreate()
    {
        $model = new Dishtable();

        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->ownerid = $this->ownerid;
            $model->store_id = $request->get("storeid");
            if($model->validate() && $model->save()){
                ColorHelper::alert('新增餐牌成功！');
                return $this->redirect(['index','storeid'=>$model->store_id]);
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

            if($model->validate() && $model->save()){
                ColorHelper::alert('修改餐牌'.$model->title.'成功！');
                return $this->redirect(['index','storeid'=>$model->store_id]);
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);

        @unlink(\Yii::getAlias('@site').$model->code);

        $model->delete();

        return $this->redirect(['index','storeid'=>$model->store_id]);
    }

    //生成餐桌二维码
    public function actionCreatecode($id)
    {
        $model = Dishtable::findOne($id);
        $store = Stores::findOne($model->store_id);
        //$url = "https://326108993.com/wxapp/dish?stid=".$model->store_id."-".$model->id;
        $url = \yii\helpers\Url::to(['/wxapp/dish','stid'=>$model->store_id.'-'.$model->id],'https');
        $url = str_replace("/admin","",$url);

        $file = "/uploads/dishtable/".$model->store_id."/".$model->id.".png";
        $outfile = FileHelper::normalizePath(\Yii::getAlias('@site').$file);
        $res = UHelper::qrcode($url,$outfile);
        $bg =FileHelper::normalizePath(\Yii::getAlias('@site').'/uploads/dishtable/dish-blank.png');
        Image::watermark($bg,$outfile)->save($outfile);
        $font = FileHelper::normalizePath(\Yii::getAlias('@site').'/assets/fonts/msyhfull.ttf');
        $title = "(".$model->title.")\n".$store->name;
        Image::text($outfile,$title,$font,[10,600],['color'=>'#000000','size'=>'25'])->save($outfile);
        $model->code = $file;
        $model->path = $url;
        if($model->validate()&&$model->save()){
            ColorHelper::alert('生成二维码成功！');
        }else{
            ColorHelper::err(current($model->getFirstErrors()));
        }
        return $this->redirect(['index','storeid'=>$store->id]);
    }

    //这个是生成小程序码的，暂时放弃先
    public function actionPrintQrcode00($id)
    {
        return;
        $access_token=ColorHelper::CHENGLAN_DIANCAN_ACCESSTOKEN();

        $model = $this->findModel($id);

        if(1){
            $url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".$access_token;
            //$data['path'] = "page/main/index?sid=".$model->store_id."&tid=".$model->id;
            $data['path'] = "page/common/routers/index?sid=".$model->store_id."&tid=".$model->id;
            $data['width'] = "430";
            $res = CurlHelper::callWebServer($url,json_encode($data),"post",false);

            $dir = \Yii::getAlias("@site").DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."dishtable".DIRECTORY_SEPARATOR.$model->store_id;

            FileHelper::createDirectory($dir,777);

            $file = $dir.DIRECTORY_SEPARATOR."mendian-".$model->store_id."-zhuohao-".$model->id.".jpg";

            //$ss = file_put_contents($file,$res);
            $ss=@file_put_contents($file, $res, LOCK_EX);

            if($ss !== false){
                $model->path = $data['path'];
                $model->code ="/uploads/dishtable/".$model->store_id."/mendian-".$model->store_id."-zhuohao-".$model->id.".jpg";
                $model->save();
            }else{
                ColorHelper::err('生成二维码失败！');
            }
//            return $model->code;
        }else{
//            return $model->code;
        }
        return $this->redirect(['index','storeid'=>$model->store_id]);

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
            return $this->redirect(['index','storeid'=>$store_id]);
        }

        $table = Dishtable::findOne($id);
        $store = Stores::findOne($store_id);
        //二维码链接  https://colorsite.com/wxapp/dish?stid=1-2
        $str = \yii\helpers\Url::to(['/wxapp/dish','stid'=>$store_id.'-'.$id],'https');
        $str = str_replace("/admin","",$str);

        $content = '';                          //打印内容
        $content .= '<FS><center>'.$table->title.'</center></FS>';
        $content .= "<center>（".$store->name."）</center>\r\n";
        $content .= '<QR>'.$str.'</QR>';
        $content .= str_repeat('-',32)."\n";
        $content .= "<center>（使用微信扫一扫二维码点餐）</center>\r\n";

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
                    return $this->redirect(['index','storeid'=>$store_id]);
                }
            }
        }
        ColorHelper::alert('已打印');
        return $this->redirect(['index','storeid'=>$store_id]);

    }


    //重置餐牌
    public function actionReset($id)
    {
        $table = Dishtable::findOne($id);

        $sid = $table->store_id;
        $tid = $id;


        Dishcart::updateAll(['isdone'=>1],"`isdone`=0 and `store_id`=:sid and `tid`=:tid and `created_at`>=:time",
            [':sid'=>$sid,':tid'=>$tid,':time'=>time()-3600*4]
        );

        Dishorder::updateAll(['isdone'=>1],"`isdone`=0 and `store_id`=:sid and `table_num`=:tid and `created_at`>=:time",
            [':sid'=>$sid,':tid'=>$tid,':time'=>time()-3600*4]
        );
        ColorHelper::alert('已重置餐牌');
        return $this->redirect(['index','storeid'=>$sid]);
    }

    protected function findModel($id)
    {
        if (($model = Dishtable::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
