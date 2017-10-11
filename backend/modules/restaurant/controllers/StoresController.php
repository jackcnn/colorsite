<?php

namespace backend\modules\restaurant\controllers;

use Yii;
use common\models\Stores;
use common\models\search\StoresSearch;
use yii\web\NotFoundHttpException;
use backend\controllers\BaseController;
use yii\helpers\ColorHelper;
use yii\helpers\FileHelper;

class StoresController extends BaseController
{

    public function actionIndex()
    {

        $searchModel = new StoresSearch();
        $params = Yii::$app->request->queryParams;
        $params['StoresSearch']['ownerid'] = $this->ownerid;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate()
    {
        $model = new Stores();

        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->logo = FileHelper::upload($model,'logo');
            $model->ownerid = $this->ownerid;
            $model->token = $this->token;
            if($model->validate() && $model->save()){
                ColorHelper::alert('新增门店成功！');
                return $this->redirect(['index']);
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
            $model->logo = FileHelper::upload($model,'logo');
            if($model->validate() && $model->save()){
                ColorHelper::alert('修改门店'.$model->name.'成功！');
                return $this->redirect(['index']);
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
        $model = $this->findModel($id);
        FileHelper::unlink($model->logo);
        $model->delete();
        ColorHelper::alert('删除成功！');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Stores::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
