<?php

namespace backend\modules\restaurant\controllers;

use Yii;
use common\models\Category;
use common\models\search\CategorySearch;
use backend\controllers\BaseController;
use yii\helpers\ColorHelper;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;

class CategoryController extends BaseController
{

    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $params = Yii::$app->request->queryParams;
        $params['CategorySearch']['table'] = 'restaurant';
        $params['CategorySearch']['ownerid'] = $this->ownerid;

        $dataProvider = $searchModel->search($params);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Category();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->logo = FileHelper::upload($model,'logo');
            $model->slogo = FileHelper::upload($model,'slogo');
            $model->ownerid = $this->ownerid;
            $model->token = $this->token;
            $model->table = 'restaurant';
            if($model->validate() && $model->save()){
                ColorHelper::alert('新增分类成功！');
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
            $model->slogo = FileHelper::upload($model,'slogo');
            $model->table = 'restaurant';
            if($model->validate() && $model->save()){
                ColorHelper::alert('修改分类'.$model->name.'成功！');
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
        FileHelper::unlink($model->slogo);
        $model->delete();
        ColorHelper::alert('删除成功！');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
