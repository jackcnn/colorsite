<?php

namespace backend\modules\restaurant\controllers;

use Yii;
use common\models\Dishreceive;
use common\models\search\DishreceiveSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\Stores;

use backend\controllers\BaseController;
use yii\helpers\ColorHelper;
use yii\helpers\FileHelper;


class DishreceiveController extends BaseController
{

    public function actionIndex()
    {
        $searchModel = new DishreceiveSearch();

        $params = Yii::$app->request->queryParams;
        $params['DishreceiveSearch']['ownerid'] = $this->ownerid;
        $params['DishreceiveSearch']['store_id'] = \Yii::$app->request->get("store_id");

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'storeName' => $this->findStore($params['DishreceiveSearch']['store_id'])
        ]);
    }

    public function actionCreate()
    {
        $request = \Yii::$app->request;
        $count = Dishreceive::find()->where(['store_id'=>$request->get("store_id")])->count();
        if($count >= 3){
            ColorHelper::err('每个门店最多可添加3个收款通知者！');
            return $this->redirect(['index','store_id'=>$request->get("store_id")]);
        }
        $model = new Dishreceive();
        if($request->isPost){

            $model->load($request->post());
            $model->ownerid = $this->ownerid;
            $model->store_id = $request->get("store_id");

            if($model->validate() && $model->save()){
                ColorHelper::alert('新增收款通知者成功！');
                return $this->redirect(['index','store_id'=>$request->get("store_id")]);
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }
        $model->loadDefaultValues();
        return $this->render('create', [
            'model' => $model,
            'storeName'=> $this->findStore($request->get("store_id"))
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());


            if($model->validate() && $model->save()){
                ColorHelper::alert('修改收款通知者'.$model->name.'成功！');
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

    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();

        $model = $this->findModel($id);

        $model->delete();

        return $this->redirect(['index','store_id'=>$model->store_id]);
    }

    //公众号绑定
    public function actionBindPublic($id,$store_id)
    {
        return $this->render('bind-public',['id'=>$id,'store_id'=>$store_id,'token'=>$this->token]);
    }

    //解除绑定
    public function actionClear($id)
    {
        $model = $this->findModel($id);

        $model->openid = null;
        $model->wxname = null;
        $model->wxpic = null;
        if($model->validate() && $model->save()){
            ColorHelper::alert('解除绑定成功！');
            return $this->redirect(['index','store_id'=>$model->store_id]);
        }else{
            ColorHelper::err(current($model->getFirstErrors()));
        }

    }

    protected function findModel($id)
    {
        if (($model = Dishreceive::findOne($id)) !== null) {
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
