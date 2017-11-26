<?php
/**
 * Date: 2017/10/16 0016
 * Time: 13:53
 */

namespace common\modules\payments\controllers;

use common\models\Clerk;
use common\models\Stores;
use common\weixin\WxCommon;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\ColorHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\Dishorder;
use yii\helpers\CurlHelper;
use common\weixin\WxPayHelper;


class WxnotifyController extends controller
{
    //微信的信息不要做csrf验证
    public $enableCsrfValidation = false;

    public function actionDish(){//橙蓝点餐的微信回调

        $postData = file_get_contents('php://input');

        \Yii::info($postData,__METHOD__);

        $postArray = ArrayHelper::xmlToArray($postData);

        $transaction = \Yii::$app->db->beginTransaction();
        $xml['return_code']="SUCCESS";
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

                $store = Stores::findOne($order->store_id);

                $order->paytime=time();
                $order->transaction_id=$postArray['transaction_id'];
                $order->status=2;
                $order->paytype = "wxpay";
                $order->payopenid = $postArray['sub_openid'];
                $order->payinfo=Json::encode($postArray);
                $order->isdone = 1;//订单已完成
                if($order->validate() && $order->save()){
                    //下发模板消息，先给付款人发送
                    self::sendtmp_to_payer($order,$store,$postArray['sub_openid']);
                    //橙蓝公众号收款通知模板ID，OPENTM411290721
                    self::sendtmp_to_clerk($order,$store);

                }else{
                    $err=$postArray;
                    $err['addMsg']=current($order->getFirstErrors());
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

    public static function sendtmp_to_payer($order,$store,$openid)
    {
        $prepay = json_decode($order->unifiedorder_res,1);
        $access_token=ColorHelper::CHENGLAN_DIANCAN_ACCESSTOKEN();
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=$access_token";
        $send_data['touser'] = $openid;
        $send_data['template_id'] = "BMjZV4JI5ysZ_Z_Cq-HgTUm1_7VSP27NOQKLucHdvLk";
        $send_data['form_id'] = $prepay['prepay_id'];
        $send_data['data'] = [
            'keyword1'=>['value'=>$order->id,'color'=>'#173177'],//单号
            'keyword2'=>['value'=>$order->title,'color'=>'#173177'],//商品信息
            'keyword3'=>['value'=>($order->amount/100).'元','color'=>'#173177'],//付款金额
            'keyword4'=>['value'=>date("Y-m-d H:i:s",$order->paytime),'color'=>'#173177'],//付款时间
            'keyword5'=>['value'=>$order->ordersn,'color'=>'#173177'],//订单编号
            'keyword6'=>['value'=>'微信支付','color'=>'#173177'],//支付方式
            'keyword7'=>['value'=>$store->name,'color'=>'#173177'],//门店
        ];
        $send_data['emphasis_keyword'] = "keyword1.DATA";
        $res = CurlHelper::callWebServer($url,json_encode($send_data),"post",false);
    }

    public static function sendtmp_to_clerk($order,$store)
    {
        $accessToken = WxCommon::accessToken('CHENGLAN');
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$accessToken";

        $post['template_id'] = 'zQABVFbNomal1DPlGrZWiDszZKYoFqoSlArNELMgwNA';
        $post['data'] = [
            'first'=>['value'=>'您有新的收款订单','color'=>'#173177'],
            'keynote1'=>['value'=>($order->amount/100).'元','color'=>'#173177'],
            'keynote2'=>['value'=>'微信支付','color'=>'#173177'],
            'keynote3'=>['value'=>$order->ordersn,'color'=>'#173177'],
            'keynote4'=>['value'=>date('Y-m-d H:i:s',$order->paytime),'color'=>'#173177'],
            'keynote5'=>['value'=>'门店：'.$store->name.'（'.$order->title.'）','color'=>'#173177'],
            'remark'=>['value'=>'橙蓝点餐服务平台','color'=>'#173177'],
        ];
        //查找接收信息的人
        $receiver = Clerk::find()->where(['store_id'=>$store->id,'receive'=>1])
            ->andWhere(['<>','public_openid',''])->asArray()->all();

        foreach($receiver as $key=>$value){
            $post['touser'] = $value['public_openid'];
            $res = CurlHelper::callWebServer($url,json_encode($post),"post",false);
        }

    }
}