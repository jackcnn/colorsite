<?php

namespace backend\modules\restaurant\controllers;

use common\models\Dishspec;
use Yii;
use common\models\Dishes;
use common\models\search\DishesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\controllers\BaseController;
use yii\helpers\ColorHelper;
use yii\helpers\FileHelper;

class DishesController extends BaseController
{

    public function actionIndex()
    {
        $searchModel = new DishesSearch();

        $params = Yii::$app->request->queryParams;
        $params['DishesSearch']['ownerid'] = $this->ownerid;

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'category'=>$this->category(),
        ]);
    }


    public function actionCreate()
    {
        $model = new Dishes();

        $request = \Yii::$app->request;
        if($request->isPost){
            $post = $request->post("Dishes");
            $model->load($request->post());
            $model->cover = FileHelper::upload($model,'cover');
            $model->ownerid = $this->ownerid;
            $model->token = $this->token;
            $model->price = intval($post['price']*100);
            $model->oprice = intval($post['oprice']*100);
            if($post['multi'] > 0){
                $spec_name = $request->post("spec_name");
                $spec_price = $request->post("spec_price");
                $spec_stock = $request->post("spec_stock");
                $spec = [];

                foreach ($spec_name as $key=>$value){
                    $spec[$key]['name'] = $value;
                    $spec[$key]['price'] = intval($spec_price[$key]*100);
                    $spec[$key]['stock'] = $spec_stock[$key];
                }
                $model->spec = json_encode($spec);
            }else{
                $model->multi = 0;
                $model->spec = '';
            }

            if($model->validate() && $model->save()){
                ColorHelper::alert('新增菜品成功！');
                return $this->redirect(['index']);
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }
        $model->loadDefaultValues();
        return $this->render('create', [
            'model' => $model,
            'category'=>$this->category(),
            'spec'=>$this->spec()
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $request = \Yii::$app->request;
        if($request->isPost){
            $post = $request->post("Dishes");
            $model->load($request->post());
            $model->cover = FileHelper::upload($model,'cover');
            $model->price = intval($post['price']*100);
            $model->oprice = intval($post['oprice']*100);
            if($post['multi'] > 0){
                $spec_name = $request->post("spec_name");
                $spec_price = $request->post("spec_price");
                $spec_stock = $request->post("spec_stock");
                $spec = [];

                foreach ($spec_name as $key=>$value){
                    $spec[$key]['name'] = $value;
                    $spec[$key]['price'] = intval($spec_price[$key]*100);
                    $spec[$key]['stock'] = $spec_stock[$key];
                }
                $model->spec = json_encode($spec);
            }else{
                $model->multi = 0;
                $model->spec = '';
            }
            if($model->validate() && $model->save()){
                ColorHelper::alert('修改菜品'.$model->name.'成功！');
                return $this->redirect(['index']);
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }
        $model->price = $model->price/100;
        $model->oprice = $model->oprice/100;
        return $this->render('update', [
            'model' => $model,
            'category'=>$this->category(),
            'spec'=>$this->spec()
        ]);
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        FileHelper::unlink($model->cover);
        $model->delete();
        ColorHelper::alert('删除成功！');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Dishes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //菜品分类
    protected function category()
    {
        $category = \common\models\Category::find()->where(['table'=>'restaurant','ownerid'=>$this->ownerid])->asArray()->orderBy('sort')->all();

        $data = [];
        foreach($category as $key=>$value){
            $data[$value['id']]=$value['name'];
        }

        return $data;

    }
    //规格数据
    protected function spec()
    {
        $spec = Dishspec::find()->where(['ownerid'=>$this->ownerid])->asArray()->all();
        $data = [];
        $ndata = [];
        foreach($spec as $key=>$value){
            $data[$value['id']] = $value['name'];
            $ndata[$value['id']] = explode(",",$value['content']);
        }
        return ['data'=>$data,'ndata'=>$ndata];
    }

}
