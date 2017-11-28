<?php
/**
 * Date: 2017/10/16 0016
 * Time: 13:53
 */

namespace common\modules\payments\controllers;

use common\models\Dishreceive;
use common\models\Stores;
use common\weixin\WxCommon;
use Faker\Provider\Color;
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
                    $xml['return_code']="SUCCESS";
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

            //下发模板消息，先给付款人发送
            self::sendtmp_to_payer($order,$store,$postArray['sub_openid']);
            //橙蓝公众号收款通知模板ID，OPENTM411290721
            self::sendtmp_to_clerk($order,$store);
            //支付小票机打印
            self::printcode($order,$store);

        }catch (\Exception $e){
            $xml['return_code']="FAIL";
            $xml['return_msg']=$e->getMessage();
            $transaction->rollBack();
        }
        exit(ArrayHelper::arrayToXml($xml));
    }

    //发送小程序模板消息，包括付款人和店员
    public static function sendtmp_to_payer($order,$store,$openid)
    {
        $access_token=ColorHelper::CHENGLAN_DIANCAN_ACCESSTOKEN();
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=$access_token";

        //有店员提交订单时的，付款了要发送模板消息
        if(strlen($order->formid)>5){
            $data['touser'] = $order->openid;
            $data['template_id'] = "d8T7CEalF2iovSdBL6f9KflAbslADCU8H7pB8AxeBhg";//收款通知模板消息
            $data['form_id'] = $order->formid;
            $data['data'] = [
                'keyword1'=>['value'=>($order->amount/100).'元','color'=>'#173177'],//收款金额
                'keyword2'=>['value'=>$order->title,'color'=>'#173177'],//备注
                'keyword3'=>['value'=>$store->name,'color'=>'#173177'],//商户名称
                'keyword4'=>['value'=>'微信支付','color'=>'#173177'],//付款方式
                'keyword5'=>['value'=>date("Y-m-d H:i:s",$order->paytime),'color'=>'#173177'],//收款时间
                'keyword6'=>['value'=>$order->ordersn,'color'=>'#173177'],//单号
            ];
            $data['emphasis_keyword'] = "keyword1.DATA";
            $res = CurlHelper::callWebServer($url,json_encode($data),"post",false);
        }


        //给付款人的
        $prepay = json_decode($order->unifiedorder_res,1);

        $send_data['touser'] = $openid;
        $send_data['template_id'] = "BMjZV4JI5ysZ_Z_Cq-HgTUm1_7VSP27NOQKLucHdvLk";//付款通知模板消息
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

    //发送公众号模板消息（橙蓝网络科技服务平台）
    public static function sendtmp_to_clerk($order,$store)
    {
        //查找接收信息的人
        $receiver = Dishreceive::find()->where(['store_id'=>$store->id,'is_receive'=>1])
            ->andWhere(['<>','openid',''])->asArray()->all();

        if(count($receiver)){
            $accessToken = WxPayHelper::accessToken('CHENGLAN');

            $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$accessToken";
            $post['template_id'] = 'zQABVFbNomal1DPlGrZWiDszZKYoFqoSlArNELMgwNA';
            $post['data'] = [
                'first'=>['value'=>'您有新的收款订单','color'=>'#173177'],
                'keyword1'=>['value'=>($order->amount/100).'元','color'=>'#173177'],
                'keyword2'=>['value'=>'微信支付','color'=>'#173177'],
                'keyword3'=>['value'=>$order->ordersn,'color'=>'#173177'],
                'keyword4'=>['value'=>date('Y-m-d H:i:s',$order->paytime),'color'=>'#173177'],
                'keyword5'=>['value'=>$order->title.'(单号：'.$order->id.',支付微信号：'.urldecode($order->paywxname).'）','color'=>'#173177'],
                'remark'=>['value'=>$store->name.'(橙蓝点餐服务平台)','color'=>'#173177'],
            ];

            foreach($receiver as $key=>$value){
                $post['touser'] = $value['openid'];
                $res = CurlHelper::callWebServer($url,json_encode($post),"post",false);
            }
        }

    }

    //打印付款小票
    public static function printcode($order,$store)
    {
        $content = '';
        $content .= '<FS><center>'.$tid.'号</center></FS>';
        $content .="您有新的收款订单";
        $content .= str_repeat('-',32);
        $content .= '<table>';
        $content .= '<tr><td>商品信息</td><td>'.$order->title.'</td></tr>';
        $content .= '<tr><td>支付方式</td><td>微信支付</td></tr>';
        $content .= '</table>';
        $content .= str_repeat('-',32)."\n";
        $content .= "<FS>总金额: ".($order->amount/100)."元</FS>\r\n";
        $content .= "时间: ".date('Y-m-d H:i:s',$order->paytime)."\r\n";

        $printers = Printer::find()->where(['store_id'=>$order->store_id,'isuse'=>1])->asArray()->all();
        if(count($printers)){
            foreach($printers as $key=>$value){
                $actions = json_decode($value['actions'],1);
                if(in_array("payres",$actions)){//选为打印的，开始打印
                    $machineCode = $value['machine_code'];                      //授权的终端号
                    $res = \common\vendor\yilianyun\YilianyunHelper::printer($content,$machineCode);
                    return $res;
                    if($res == 'success'){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }

    }
}