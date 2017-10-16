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
use common\weixin\WxPayHelper;
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

        ColorHelper::wxlogin($this->ownerid);


        $store = Stores::findOne($store_id);
        $order = Dishorder::find()->where(['store_id'=>$store_id,'id'=>$orderid])->asArray()->one();

        $dishes = json_decode($order['list'],1);

        $marks = $dishes['mark']?$dishes['mark']:[];

        unset($dishes['mark']);

        $order['dishes'] = $dishes;

        return $this->renderPartial("index",[
            'store'=>$store,
            'order'=>$order,
            'marks'=>$marks,
        ]);
    }

    //店员查看页面
    public function actionClerk($store_id,$orderid,$ordersn)
    {
        ColorHelper::wxlogin($this->ownerid);


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

        ColorHelper::wxlogin($this->ownerid);

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

    /*
     * 统一下单
     * */
    public function actionUnifiedorder()
    {
        $return['success']=true;
        $request=\Yii::$app->request;
        try{
            $user= \Yii::$app->user;
            $identity=$user->identity;
            if($user->isGuest){
                throw new \Exception('请先登录');
            }
            if(!$request->isPost){
                throw new \Exception('非法请求');
            }
            $store_id = $request->get("store_id");
            $orderid = $request->post("orderid");

            $store = Stores::findOne($store_id);
            $orderModel = Dishorder::find()->where(['store_id'=>$store_id,'id'=>$orderid])->one();

            if($orderModel){

                $return['orderid']=$orderModel->id;
                $return['ordersn']=$orderModel->ordersn;

                $wxconfig= WxPayHelper::getconfig($this->ownerid);

                //微信下单
                $input = new \common\weixin\lib\data\WxPayUnifiedOrder();
                $input->SetBody($store->name."结账付款");
                $input->SetAttach("记录orderid:".$orderid);
                $input->SetOut_trade_no($orderModel->ordersn);
                $input->SetTotal_fee(1);
                $input->SetTime_start(date("YmdHis",time()));
                $input->SetTime_expire(date("YmdHis", time() + 6000));
                $input->SetGoods_tag("order_tag");
                $input->SetNotify_url(Url::to(['/payments/wxnotify/dish'],true));
                $input->SetTrade_type("JSAPI");
                $input->SetAppid($wxconfig['appid']);
                $input->SetMch_id($wxconfig['mch_number']);
                $input->SetOpenid($identity->openid);
                $orderRes = WxPayHelper::unifiedOrder($input , $wxconfig['mch_key']);
                $return['jsapiparams'] = WxPayHelper::GetJsApiParameters($orderRes , $wxconfig['mch_key']);
            }else{
                throw new \Exception('订单不存在！');
            }
        }catch (\Exception $e){
            $return['success']=false;
            $return['msg']=$e->getMessage();
        }
        return $this->asJson($return);

    }



}