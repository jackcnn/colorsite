<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/15 0015
 * Time: 15:24
 */

namespace frontend\controllers;

use common\models\Category;
use common\models\Clerk;
use common\models\Dishcart;
use common\models\Dishes;
use common\models\Dishorder;
use common\models\Gallery;
use common\models\Stores;
use common\weixin\JssdkHelper;
use Yii;
use frontend\controllers\BaseController;
use yii\data\Pagination;
use yii\helpers\ColorHelper;
use yii\helpers\Url;

class OrderController extends BaseController
{

    public $enableCsrfValidation = false;

    //客户查看页面
    public function actionIndex($store_id,$orderid,$ordersn)
    {
        $store = Stores::findOne($store_id);
        $order = Dishorder::find()->where(['store_id'=>$store_id,'id'=>$orderid])->asArray()->one();

        $dishes = json_decode($order['list'],1);

        $marks = $dishes['mark']?$dishes['mark']:[];

        unset($dishes['mark']);

        $order['dishes'] = $dishes;

        //wxjssdk
        $signPackage = JssdkHelper::getSignPackage($this->ownerid);


        return $this->renderPartial("index",[
            'store'=>$store,
            'order'=>$order,
            'marks'=>$marks,
            'signPackage'=>$signPackage
        ]);
    }

    //店员查看页面
    public function actionClerk($store_id,$orderid,$ordersn)
    {


        $clerk = Clerk::find()->where(['store_id'=>$store_id,'openid'=>\Yii::$app->user->identity->openid])->one();

        if(!$clerk){//非店员跳转到首页
            return $this->redirect(['site/index','store_id'=>$store_id,'token'=>$this->token,'sn'=>$ordersn]);
        }

        $store = Stores::findOne($store_id);
        $order = Dishorder::find()->where(['store_id'=>$store_id,'id'=>$orderid])->asArray()->one();

        $dishes = json_decode($order['list'],1);

        $marks = $dishes['mark']?$dishes['mark']:[];

        unset($dishes['mark']);

        $order['dishes'] = $dishes;

        return $this->renderPartial("clerk",[
            'store'=>$store,
            'order'=>$order,
            'marks'=>$marks
        ]);
    }

    //店员修改为可以付款状态
    public function actionChangest($store_id,$orderid,$ordersn)
    {
        $request = \Yii::$app->request;

        if($request->isPost){
            $clerk = Clerk::find()->where(['store_id'=>$store_id,'openid'=>\Yii::$app->user->identity->openid])->one();
            if(!$clerk){//非店员跳转到首页
                die('抱歉，非绑定店员没有权限');
            }

            $order = Dishorder::find()->where(['store_id'=>$store_id,'id'=>$orderid])->one();

            if(!$order){
                die('订单不存在');
            }

            $order->status = 1;

            if($order->validate() && $order->save()){
                return $this->redirect(['order/clerk','store_id'=>$store_id,'token'=>$this->token,'orderid'=>$orderid,'ordersn'=>$ordersn]);
            }else{
                die(current($order->getFirstErrors()));
            }
        }



    }



}