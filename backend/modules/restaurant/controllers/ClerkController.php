<?php

namespace backend\modules\restaurant\controllers;

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

    public function actionBind($id,$store_id)
    {

        return $this->render('bind',['id'=>$id,'store_id'=>$store_id,'token'=>$this->token]);

    }


    public function actionUnbind($id,$store_id){
        $model = Clerk::find($id)->one();

        if($model){
            $model->openid = null;
            $model->wxname = null;
            $model->avatar = null;

            $model->save();

        }
        return $this->redirect(['clerk/index','store_id'=>$store_id]);

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
