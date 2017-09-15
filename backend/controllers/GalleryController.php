<?php

namespace backend\controllers;

use Yii;
use common\models\Gallery;
use common\models\search\GallerySearch;
use backend\controllers\BaseController;
use yii\helpers\ColorHelper;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
class GalleryController extends BaseController
{

    public function actionIndex()
    {
        $searchModel = new GallerySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Gallery();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->logo = FileHelper::upload($model,'logo');
            $model->ownerid = $this->ownerid;
            $model->token = $this->token;
            $model->time = (string)strtotime($request->post('Gallery')['time']);
            if($model->validate() && $model->save()){
                ColorHelper::alert('新增成功！');
                return $this->redirect(['index']);
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }
        $model->loadDefaultValues();
        $model->time = time();
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
            $model->logo = FileHelper::upload($model,'logo');
            $model->ownerid = $this->ownerid;
            $model->token = $this->token;
            $model->time = (string)strtotime($request->post('Gallery')['time']);
            if($model->validate() && $model->save()){
                ColorHelper::alert('修改成功！');
                return $this->redirect(['index']);
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }
        $model->loadDefaultValues();
        $model->time = time();
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Gallery::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
