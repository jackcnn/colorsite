<?php
/**
 * Date: 2017/10/16 0016
 * Time: 13:53
 */

namespace common\modules\payments\controllers;

use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\ColorHelper;
use yii\helpers\Json;
use yii\helpers\UHelper;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\Dishorder;

use common\weixin\WxPayHelper;


class WxnotifyController extends controller
{
    //微信的信息不要做csrf验证
    public $enableCsrfValidation = false;

    public function actionDish(){

        $postData = file_get_contents('php://input');


        \Yii::info($postData,__METHOD__);

        $postArray = ArrayHelper::xmlToArray($postData);

        //ColorHelper::dump($postArray);

        $transaction = \Yii::$app->db->beginTransaction();
        $xml['return_code']="Ok";
        try{
            if(strtoupper($postArray['result_code'])=="SUCCESS"){
                $order=Dishorder::find()->where(['ordersn'=>$postArray['out_trade_no']])->one();
                if(!$order){
                    $err=$postArray;
                    $err['addMsg']='订单不存在';
                    \Yii::info($err,__METHOD__);
                    throw new \Exception('order-no-exist！');
                }


                $checkSign=WxPayHelper::createSign($postArray,CHENGLAN_MCHKEY);
                if($checkSign != $postArray['sign']){//验证签名
                    $err=$postArray;
                    $err['addMsg']='sign-error-'.$checkSign;
                    \Yii::info($err,__METHOD__);
                    throw new \Exception($err['addMsg']);
                }
                if(($order->amount != $postArray['total_fee']) || $postArray['total_fee']<=0){
                    $err=$postArray;
                    $err['addMsg']='amount-error-'.($order['amount']*100).'-'.$postArray['total_fee'];
                    \Yii::info($err,__METHOD__);
                    throw new \Exception($err['addMsg']);
                }

                $order->paytime=time();
                $order->transaction_id=$postArray['transaction_id'];
                $order->status=2;
                $order->paytype = "wxpay";
                $order->payopenid = $postArray['openid'];

                $order->payinfo=Json::encode($postArray);
                if(!$order->save()){
                    $err=$postArray;
                    $err['addMsg']='order-change-fail';
                    \Yii::info($err,__METHOD__);
                    throw new \Exception($err['addMsg']);
                }
            }else{
                throw new \Exception('transaction-fail');
            }
            $transaction->commit();
        }catch (\Exception $e){
            $xml['return_code']="FAIL";
            $xml['return_msg']=$e->getMessage();
            $transaction->rollBack();
        }
        exit(ArrayHelper::arrayToXml($xml));
    }
}