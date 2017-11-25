<?php

namespace backend\modules\restaurant\controllers;

use common\models\Stores;
use DoctrineTest\InstantiatorTestAsset\FinalExceptionAsset;
use Yii;
use common\models\Dishtable;
use common\models\search\DishtableSearch;
use yii\helpers\CurlHelper;
use yii\helpers\FileHelper;
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

        $model->delete();

        return $this->redirect(['index','storeid'=>$model->store_id]);
    }

    //打印餐桌二维码
    public function actionPrintQrcode($id)
    {



    }

    //这个是生成小程序码的，暂时放弃先
    public function actionCreatecode($id)
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



    protected function findModel($id)
    {
        if (($model = Dishtable::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
