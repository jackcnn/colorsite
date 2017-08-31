<?php
/**
 * Date: 2016/8/1
 * Time: 16:25
 * 微信推广支持，包括生成二维码，长链接转短链接
 */
namespace common\weixin;

use yii\helpers\CurlHelper;
use yii\helpers\UHelper;

class WxqrcodeHelper
{

    const wx_qr_create_ticket='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=';

    const wx_get_qrcode='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=';

    const wx_url_long2short='https://api.weixin.qq.com/cgi-bin/shorturl?access_token=';


    /**
     * 生成带参数的二维码 - 第一步 创建二维码ticket-获取临时二维码的ticket
     * @parame $expireSeconds 该二维码有效时间，以秒为单位。 最大不超过2592000（即30天），此字段如果不填，则默认有效期为30秒。
     * @parame $sceneId 场景值ID，临时二维码时为32位非0整型
     */
    public static function createTicket($sceneId , $expireSeconds ,$accessToken){
        $queryUrl = self::wx_qr_create_ticket.$accessToken;
        $queryAction = 'POST';
        $template = array();

        $template['expire_seconds'] = $expireSeconds;
        $template['action_name'] = 'QR_SCENE';
        $template['action_info']['scene']['scene_id'] = $sceneId;

        $template = json_encode($template);
        return CurlHelper::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 生成带参数的二维码 - 第一步 创建二维码ticket-获取永久二维码的ticket
     * @parame $sceneId 场景值ID，永久二维码时最大值为100000（目前参数只支持1--100000）
     * @parame $sceneStr 	场景值ID（字符串形式的ID），字符串类型，长度限制为1到64，仅永久二维码支持此字段
     */
    public static function createLimitTicket($sceneStr='',$sceneId,$accessToken){
        $queryUrl = self::wx_qr_create_ticket.$accessToken;
        $queryAction = 'POST';
        $template = array();

        $template['action_name'] = 'QR_LIMIT_STR_SCENE';
        if($sceneStr!=''){
            $template['action_info']['scene']['scene_str'] = $sceneStr;
        }else{
            $template['action_info']['scene']['scene_id'] = $sceneId;
        }

        $template = json_encode($template);
        return CurlHelper::callWebServer($queryUrl, $template, $queryAction);
    }

    /*
     * 使用PHPQRCODE 直接生成一个二维码
     * @param $text 二维码的解析地址，传入ticket 接口返回的URL
     * @param $outfile 生成的二维码的文件地址
     * */
    public static function creatQrimg($text,$outfile,$box)
    {
        UHelper::qrcode($text,$outfile,$box);
        return $outfile;
    }


    /**
     * 生成带参数的二维码 - 第二步 通过ticket换取二维码
     * @param $ticket Popularize::createTicket()获得的
     * @param $filename String 文件路径，如果不为空，则会创建一个图片文件，二维码文件为jpg格式，保存到指定的路径
     * @return 直接echo本函数的返回值，并在调用页面添加header('Content-type: image/jpg');，将会展示出一个二维码的图片。
     */
    public static function getQrcode($ticket, $filename=''){
        $queryUrl = self::wx_get_qrcode.urlencode($ticket);
        $queryAction = 'GET';
        $result = Curl::callWebServer($queryUrl, '', $queryAction, 0);
        if(!empty($filename)){
            file_put_contents($filename, $result);
        }
        return $result;
    }

    /**
     * 将一条长链接转成短链接。
     * 主要使用场景：开发者用于生成二维码的原链接（商品、支付二维码等）太长导致扫码速度和成功率下降，将原长链接通过此接口转成短链接再生成二维码将大大提升扫码速度和成功率。
     * @param $longUrl String 需要转换的长链接，支持http://、https://、weixin://wxpay 格式的url
     * @return array('errcode'=>0, 'errmsg'=>'错误信息', 'short_url'=>'http://t.cn/asdasd')错误码为0表示正常
     */
    public static function long2short($longUrl,$accessToken){
        $queryUrl = self::wx_url_long2short.$accessToken;
        $queryAction = 'POST';
        $template = array();
        $template['long_url'] = $longUrl;
        $template['action'] = 'long2short';
        return Curl::callWebServer($queryUrl, '', $queryAction);
    }
}