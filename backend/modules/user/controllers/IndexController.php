<?php

namespace backend\modules\user\controllers;

use Yii;
use common\models\User;
use common\models\search\UserSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\ColorHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IndexController implements the CRUD actions for User model.
 */
class IndexController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionAdd()
    {
        die;
        $model = new User();
        $count = $model::find()->count();

        $model->parent_id =0;
        $model->token = 'tokentokentoken'.$count;
        $model->is_admin = 0;
        $model->username = 'username'.$count;
        $model->password = 'password'.$count;
        $model->nickname = 'nickname'.$count;
        $model->avatar = 'avatar'.$count;

        $model->save();

    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if($_POST){
            $model->load(Yii::$app->request->post());


            $model->username = \yii\helpers\FileHelper::upload($model,'token');

            ColorHelper::dump($model);die;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->updated_at ='1232@qq.com';
            $model->created_at = 1504668631;
            $model->password = '123456';
            $model->is_admin =0;
            $model->expire = json_encode(['one','three']);
            $model->nickname = 1;
            $model->avatar = 'im avatar';
            $model->is_active = 1;
            $model->username = '/uploads/common/201709/2bcb8014395d2482f800022e0ce6562e.jpg';
            $model->token = '/uploads/common/201709/2bcb8014395d2482f800022e0ce6562e.jpg';
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
