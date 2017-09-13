<?php
/**
 * Date: 2017/9/12 0012
 * Time: 18:15
 * 第三方配置，如微信，支付宝等
 */
namespace backend\controllers;

use common\models\Thirdcfg;
use Yii;
use backend\controllers\BaseController;
use yii\db\Exception;
use yii\helpers\ColorHelper;
use yii\helpers\FileHelper;

class ThirdcfgController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionWeixin()
    {
        $model = Thirdcfg::findOne(['type'=>'weixin','userid'=>\Yii::$app->user->id]);
        if(!$model){
            $model = new Thirdcfg();
        }
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->userid = \Yii::$app->user->identity->id;
            $model->token = \Yii::$app->user->identity->token;
            $model->apiclient_cert = FileHelper::upload($model,'apiclient_cert',1,true,true);
            $model->apiclient_key = FileHelper::upload($model,'apiclient_key',1,true,true);
            if($model->validate() && $model->save()){
                ColorHelper::alert('微信设置保存成功！');
                return $this->redirect(['index']);
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }



        return $this->render('weixin',[
            'model'=>$model
        ]);
    }


}