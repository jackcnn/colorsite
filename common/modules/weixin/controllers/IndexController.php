<?php
/**
 * Date: 2017/9/12 0012
 * Time: 17:56
 * weixin接入
 */
namespace common\modules\weixin\controllers;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\CurlHelper;
use yii\helpers\Json;
use common\weixin\ResponseHelper;
use common\weixin\WeixinHelper;


class IndexController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     *微信接收信息入口http://friends.com/weixin/default/index.html?wid=1
     */
    public function actionIndex()
    {
        $request=\Yii::$app->request;
        /*
         * 微信接入
         * */
        if($request->get('signature') && $request->get('timestamp') && $request->get('nonce') && $request->get('echostr')){

            if(WeixinHelper::checkSignature($request->get('wid'))){
                die($request->get('echostr'));
            }else{
                die(false);
            }
        }
        /*
         * 获取微信传输过来的信息
         * */

        $postData = file_get_contents('php://input');

        if(0){//测试的时候打开
            $postData="<xml><ToUserName><![CDATA[gh_06d5468fd094]]></ToUserName><FromUserName><![CDATA[o8cXMs4OqpFLIWW_nMx8lmelYSmE]]></FromUserName><CreateTime>1469786671</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[哈哈哈回家]]></Content><MsgId>6312685684467356188</MsgId></xml>";
        }

        //\Yii::info($postData,__METHOD__);

        if(!empty($postData)){
            $wid= $request->get('wid');
            $accessToken=WeixinHelper::accessToken($wid);
            $postArray = ArrayHelper::xmlToArray($postData);
            /*
             * 消息发送者的openid
             * */
            $wp_openid = $postArray["FromUserName"];

            /*
             * 公众号
             * */
            $wp_number = $postArray["ToUserName"];
            /*
             * 消息类型
             * */
            $MsgType = strtolower($postArray["MsgType"]);

            /*
             * 回复输出的字符串，方便加解密
             * */
            $backData="";

            switch($MsgType){
                /*
                 * 发送文本消息
                 * */
                case 'text':

                    $content="you has send something to me:'".$postArray['Content']."'";

                    $backData=ResponseHelper::text($wp_openid,$wp_number,$content);

                    break;
                /*
                 * 事件推送，下面又分为菜单推送和二维码扫描等多个事件类型
                 * */
                case 'event':

                    $backData=self::handleEvent($postArray,$wid,$accessToken);

                    break;

                /*
                 * 发送地理位置
                 * */
                case 'location':
                    $content="你发送了一个定位给我^-^";

                    $backData=ResponseHelper::text($wp_openid,$wp_number,$content);
                    break;
                /*
                 * 发送链接
                 * */
                case 'link':
                    $content="你发送了一个链接给我^-^";

                    $backData=ResponseHelper::text($wp_openid,$wp_number,$content);
                    break;
                /*
                 * 发送图片
                 * */
                case 'image':

                    $content="你发送了一张图片给我^-^";

                    $backData=ResponseHelper::text($wp_openid,$wp_number,$content);

                    break;
                /*
                 * 发送语音
                 * */
                case 'voice':

                    $content="你发送了一段语音给我^-^，抱歉我无法识别";
                    $backData=ResponseHelper::text($wp_openid,$wp_number,$content);

                    break;
                /*
                 * 发送视频
                 * */
                case 'video':
                    $content="你发送了一段视频给我^-^，谢谢";
                    $backData=ResponseHelper::text($wp_openid,$wp_number,$content);
                    break;
                /*
                 * 发送小视频
                 * */
                case 'shortvideo':
                    $content="你发送了一段短视频给我^-^，谢谢";
                    $backData=ResponseHelper::text($wp_openid,$wp_number,$content);
                    break;
            }

            die($backData);

        }
    }


    /*
     * 微信推送事件处理
     * */
    public static function handleEvent($postArray,$wid,$accessToken)
    {

        //消息发送者的openid
        $wp_openid = $postArray["FromUserName"];
        //公众号
        $wp_number = $postArray["ToUserName"];

        $event=strtolower($postArray["Event"]);

        $backData="";

        switch($event){
            /*
             * 订阅公众号事件推送
             * */
            case 'subscribe':
                /*
                 * $eventkey 带参数二维码的参数，把前缀过滤掉了
                 * */
                $eventkey=str_replace('qrscene_','',trim($postArray["EventKey"]));

                if($eventkey){//扫码订阅公众号事件推送

                    $content="<a href='http://www.baidu.com'>扫码订阅公众号了</a>\n感谢你".$eventkey;

                    $backData = ResponseHelper::text($wp_openid,$wp_number,$content);
                }else{//普通关注

                    $content="<a href='http://www.baidu.com'>订阅公众号了</a>\n感谢你";

                    $backData = ResponseHelper::text($wp_openid,$wp_number,$content);

                }

                break;
            /*
             * 取消订阅公众号事件推送
             * */
            case 'unsubscribe':


                break;
            /*
             * 用户已关注时扫描带参数二维码的事件推送
             * */
            case 'scan':

                /* $eventkey 带参数二维码的参数，把前缀过滤掉了 */
                $eventkey=str_replace('qrscene_','',trim($postArray["EventKey"]));

                $content="<a href='http://www.baidu.com'>扫码了</a>\n感谢你".$eventkey;

                $backData = ResponseHelper::text($wp_openid,$wp_number,$content);


                break;
            /*
             * 菜单点击事件
             * */
            case 'click':
                /*
                 * $eventkey 自定义菜单的时候写的key值,
                 *  */
                $backData=self::menuClickEvent($postArray,$wid,$accessToken);

                break;
        }

        return $backData;

    }

    private static function menuClickEvent($postArray,$wid,$accessToken)
    {
        //消息发送者的openid
        $wp_openid = $postArray["FromUserName"];
        //公众号
        $wp_number = $postArray["ToUserName"];

        //$eventkey=explode("_",strtolower(trim($postArray["EventKey"])));

        $eventkey = trim($postArray["EventKey"]);

        $content = "你点击按钮的key值为‘".$eventkey."’";

        $backData = ResponseHelper::text($wp_openid,$wp_number,$content);

        return $backData;

    }
}