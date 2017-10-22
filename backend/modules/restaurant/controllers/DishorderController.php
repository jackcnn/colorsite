<?php

namespace backend\modules\restaurant\controllers;

use common\models\Clerk;
use common\models\Member;
use common\models\Stores;
use Yii;
use common\models\Dishorder;
use common\models\search\DishorderSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;


class DishorderController extends BaseController
{

    public function actionIndex()
    {
        $searchModel = new DishorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'stores' =>$this->findStores()
        ]);
    }



    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {

            $model->paytime = date("Y-m-d H:i:s",$model->paytime);

            $model->amount = $model->amount/100;

            $member = Member::find()->where(['ownerid'=>$this->ownerid,'openid'=>$model->payopenid])->one();

            $clerk  = Clerk::find()->where(['ownerid'=>$this->ownerid,'openid'=>$model->openid])->one();

            $model->payopenid = $member->wxname;
            $model->openid = $clerk->wxname;

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    protected function findStores()
    {
        $stores = Stores::find()->where(['ownerid'=>$this->ownerid])->asArray()->all();

        $data = [];

        foreach ($stores as $key=>$value){

            $data[$value['id']] = $value['name'];

        }

        return $data;


    }


    protected function findModel($id)
    {
        if (($model = Dishorder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
