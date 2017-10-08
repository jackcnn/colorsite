<?php

namespace backend\modules\restaurant\controllers;

use Yii;
use common\models\Dishspec;
use common\models\search\DishspecSearch;
use yii\web\NotFoundHttpException;
use backend\controllers\BaseController;
use yii\helpers\ColorHelper;



class DishspecController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new DishspecSearch();
        $params = Yii::$app->request->queryParams;
        $params['CategorySearch']['ownerid'] = $this->ownerid;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Dishspec();

        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->ownerid = $this->ownerid;
            $model->token = $this->token;
            if($model->validate() && $model->save()){
                ColorHelper::alert('新增规格成功！');
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
            if($model->validate() && $model->save()){
                ColorHelper::alert('修改规格'.$model->name.'成功！');
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = Dishspec::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
