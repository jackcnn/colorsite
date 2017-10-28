<?php

namespace backend\modules\restaurant\controllers;

use common\models\Stores;
use Yii;
use common\models\Printer;
use common\models\search\PrinterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use yii\helpers\ColorHelper;

class PrinterController extends BaseController
{



    public function actionIndex()
    {
        $searchModel = new PrinterSearch();
        $params = Yii::$app->request->queryParams;
        $params['PrinterSearch']['ownerid'] = $this->ownerid;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'stores'=>$this->findStore($this->ownerid)
        ]);
    }

    /**
     * Displays a single Printer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreate()
    {
        $model = new Printer();

        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->ownerid = $this->ownerid;
            $postData = $request->post("Printer");
            $model->actions = json_encode($postData['actions']);

            if($model->validate() && $model->save()){
                ColorHelper::alert('新增打印机成功！');
                return $this->redirect(['index']);
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }
        $model->loadDefaultValues();
        return $this->render('create', [
            'model' => $model,
            'stores'=>$this->findStore($this->ownerid)
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $postData = $request->post("Printer");
            $model->actions = json_encode($postData['actions']);

            if($model->validate() && $model->save()){
                ColorHelper::alert('修改打印机'.$model->title.'成功！');
                return $this->redirect(['index']);
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }
        return $this->render('update', [
            'model' => $model,
            'stores'=>$this->findStore($this->ownerid)
        ]);
    }

    public function actionPrinter($id)
    {
        $model = $this->findModel($id);

        $store = Stores::findOne($model->store_id);

        $data = json_decode($model->actions,1);
        $actions = '';
        if(in_array('qrcode',$data)){
            $actions.='排号打印';
        }
        if(in_array('dishes',$data)){
            $actions.=',菜单打印';
        }


        $content = "";

        $content .= "<FS><center>打印机信息</center></FS>";
        $content .= str_repeat('-',32);
        $content .= "名称：".$model->title."\r\n";
        $content .= "终端号：".$model->machine_code."\r\n";
        $content .= "操作:".$actions."\r\n";
        $content .= "所属门店:".$store->name."\r\n";
        $content .= "打印时间：".date("Y-m-d H:i:s",time());

        $machineCode = $model->machine_code;                      //授权的终端号
        $res = \common\vendor\yilianyun\YilianyunHelper::printer($content,$machineCode);
        if($res == 'success'){
            ColorHelper::alert('打印成功！');
        }else{
            ColorHelper::err('打印失败！');
        }
        return $this->redirect(['index']);
    }

    public function actionCode()
    {

        return $this->render("code");

    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = Printer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findStore($ownerid)
    {

        $data = Stores::find()->where(['ownerid'=>$ownerid])->asArray()->all();

        $list = [];

        foreach ($data as $key=>$value){
            $list[$value['id']] = $value['name'];
        }
        return $list;
    }
}
