<?php

namespace backend\modules\restaurant\controllers;

use common\models\Stores;
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


    public function actionCreatecode($id)
    {
        $appid = "wx0dd0829415ec47da";
        $appsecret = "d28911cd2ad0a767bb76e7ab237f3656";
        $cache = \Yii::$app->cache;
        $access_token = $cache->get("diancan-wxapp");
        if(!$access_token){
            $parame['grant_type']='client_credential';
            $parame['appid']=$appid;
            $parame['secret']=$appsecret;
            $return=CurlHelper::callWebServer("https://api.weixin.qq.com/cgi-bin/token",$parame);
            if(isset($return['access_token']) && isset($return['expires_in'])){
                $cache->set('diancan-wxapp',$return['access_token'],intval($return['expires_in']-200));
            }else{
                throw new HttpException('access token 获取失败！');
            }
            $access_token = $return['access_token'];
        }

        $model = $this->findModel($id);

        if(!$model->code){
            $url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".$access_token;
            $data['path'] = "page/main/index?sid=".$model->store_id."&tid=".$model->id;
            $data['width'] = "430";
            $res = CurlHelper::callWebServer($url,json_encode($data),"post",false);

            $dir = \Yii::getAlias("@site")."/uploads/dishtable/".$model->store_id;

            FileHelper::createDirectory($dir,777);

            $file = $dir."/mendian-".$model->store_id."-zhuohao-".$model->id.".jpg";

            $ss = file_put_contents($file,$res);

            $model->path = $data['path'];
            $model->code ="/uploads/dishtable/".$model->store_id."/mendian-".$model->store_id."-zhuohao-".$model->id.".jpg";
            $model->save();
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
