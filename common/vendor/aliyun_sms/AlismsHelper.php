<?php
/**
 * Created by PhpStorm.
 * User: lurongze
 * Date: 2017/10/24
 * Time: 17:56
 */
namespace common\vender\aliyun_sms;
use yii\base\NotSupportedException;

/**
 *阿里云短信发送
 *
 */
class AlismsHelper
{

    //使用326108993@qq.com里面的短信
    public static function alisms_base($phone,$code)
    {

        // 调用示例：
        require_once dirname(__DIR__) . '/aliyun_sms/php/api_demo/SmsDemo.php';

        //header('Content-Type: text/plain; charset=utf-8');

        $demo = new \SmsDemo(
            "LTAIZXZicZRv3Kqk",
            "hupsznlXQMbRmpShT1UsqO71nRENu8"
        );

        $timestamp = time();

        $response = $demo->sendSms(
            "橙蓝网络", // 短信签名
            "SMS_105800100", // 短信模板编号
            "$phone", // 短信接收者
            Array(  // 短信模板中字段的值
                "code"=>"$code",
            ),
            "$timestamp"
        );
//        Array正常的时候的返回
//        (
//            [Message] => OK
//            [RequestId] => 7E705699-CB8C-4D3E-808E-A38BB66FE879
//            [BizId] => 993708808839587265^0
//            [Code] => OK
//          )

        return \yii\helpers\ArrayHelper::toArray($response);

    }

}