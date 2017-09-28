<?php
/**
 * Date: 2016/8/2
 * Time: 15:33
 * jssdk
 */
namespace common\weixin;

use common\weixin\WxCommon;
use yii\helpers\ColorHelper;
use yii\helpers\CurlHelper;

class JssdkHelper extends WxCommon
{
    const wx_get_jsapi_ticket="https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=";

    public static function getSignPackage($owid,$url='',$debug=false) {
        $jsapiTicket = self::getJsApiTicket($owid);

        // 注意 URL 一定要动态获取，不能 hardcode.
        $url=$url?$url:(\Yii::$app->request->absoluteUrl);

        $timestamp = time();

        $nonceStr = \Yii::$app->security->generateRandomString(16);

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $config = self::getconfig($owid);

        if($config['isuse']){
            $appid=$config['appid'];
        }else{
            $newmodel=self::getconfig(ADMIN_OWID);
            $appid=$newmodel['appid'];
        }

//        wx.config({
//        debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
//        appId: '', // 必填，公众号的唯一标识
//        timestamp: , // 必填，生成签名的时间戳
//        nonceStr: '', // 必填，生成签名的随机串
//        signature: '',// 必填，签名，见附录1
//        jsApiList: [] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
//        });
        $signPackage = [
            "debug"     => $debug,
            "appId"     => $appid,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        ];
        return $signPackage;
    }

    private static function getJsApiTicket($owid)
    {
        $cache=\Yii::$app->cache;
        //$api_ticket=$cache->get('wx_js_api_ticket_'.$owid)
        if(0){

            return $api_ticket;

        }else{
            $accessToken= self::accessToken($owid);

            $ticket = CurlHelper::callWebServer(self::wx_get_jsapi_ticket.$accessToken);

            ColorHelper::dump($ticket);die;

            $cache->set('wx_js_api_ticket_'.$owid,$ticket['ticket'],7000);

            return $ticket['ticket'];
        }
    }



}