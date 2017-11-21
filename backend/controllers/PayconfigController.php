<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/21 0021
 * Time: 11:56
 */
namespace backend\controllers;
use common\models\Payconfig;
use Yii;
use backend\controllers\BaseController;
use yii\db\Exception;
use yii\helpers\ColorHelper;
use yii\helpers\FileHelper;

class PayconfigController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionWeixin()
    {
        $model = Payconfig::findOne(['type'=>'weixin','ownerid'=>$this->ownerid]);
        if(!$model){
            $model = new Payconfig();
        }
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->type = "weixin";
            $model->ownerid = $this->ownerid;
            $model->cert_path = FileHelper::upload($model,'cert_path',[0,0],false,1,true,true);
            $model->key_path = FileHelper::upload($model,'key_path',[0,0],false,1,true,true);
            if($model->validate() && $model->save()){
                ColorHelper::alert('微信支付设置保存成功！');
                return $this->redirect(['index']);
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }
        return $this->render('weixin',[
            'model'=>$model
        ]);
    }

    public function actionAlipay()
    {
        $model = Payconfig::findOne(['type'=>'alipay','ownerid'=>$this->ownerid]);
        if(!$model){
            $model = new Payconfig();
        }
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->type = "alipay";
            $model->ownerid = $this->ownerid;
            $model->cert_path = FileHelper::upload($model,'cert_path',[0,0],false,1,true,true);
            $model->key_path = FileHelper::upload($model,'key_path',[0,0],false,1,true,true);
            if($model->validate() && $model->save()){
                ColorHelper::alert('支付宝支付设置保存成功！');
                return $this->redirect(['index']);
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }
        return $this->render('alipay',[
            'model'=>$model
        ]);
    }
}