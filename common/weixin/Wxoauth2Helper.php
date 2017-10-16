<?php
/**
 * Date: 2016/7/28
 * Time: 11:38
 */
namespace common\weixin;
use yii\helpers\CurlHelper;

class Wxoauth2Helper
{
    const wx_oauth2_getcode='https://open.weixin.qq.com/connect/oauth2/authorize';

    const wx_oauth2_access_token='https://api.weixin.qq.com/sns/oauth2/access_token';

    const wx_oauth2_refresh_token='https://api.weixin.qq.com/sns/oauth2/refresh_token';

    const wx_oauth2_get_userinfo='https://api.weixin.qq.com/sns/userinfo';

    /*
     *跳转链接以获取code
     * url:wx_oauth2_getcode,scope ''snsapi_userinfo,snsapi_base
     * $redirect_uri 传入链接
     * */
    public static function getcode($redirect_uri,$appid,$scope='snsapi_base',$state=1)
    {
        //授权后重定向的回调链接地址，请使用urlencode对链接进行处理
        $redirect_uri = urlencode($redirect_uri);
        //返回类型，请填写code
        $response_type = 'code';
        //构造请求微信接口的URL
        $url = self::wx_oauth2_getcode.'?appid='.$appid.'&redirect_uri='.$redirect_uri.'&response_type='.$response_type.'&scope='.$scope.'&state='.$state.'#wechat_redirect';

        return \Yii::$app->response->redirect($url)->send();

        //die;

    }

    /*
     *通过code换取网页授权access_token
     * Array(access_token, expires_in, refresh_token, openid, scope)
     * */
    public static function getTokenAndOpenid($code,$appid,$appsecret)
    {
        //填写为authorization_code
        $grant_type = 'authorization_code';
        //构造请求微信接口的URL
        $url = self::wx_oauth2_access_token.'?appid='.$appid.'&secret='.$appsecret.'&code='.$code.'&grant_type='.$grant_type.'';
        //请求微信接口, Array(access_token, expires_in, refresh_token, openid, scope)
        return CurlHelper::callWebServer($url);
    }

    /**
     * 刷新access_token（如果需要）
     * 由于access_token拥有较短的有效期，当access_token超时后，可以使用refresh_token进行刷新，refresh_token拥有较长的有效期（7天、30天、60天、90天），当refresh_token失效的后，需要用户重新授权。
     * @param $refreshToken 通过本类的第二个方法getAccessTokenAndOpenId可以获得一个数组，数组中有一个字段是refresh_token，就是这里的参数
     *
     * @return array(
    "access_token"=>"网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同",
    "expires_in"=>access_token接口调用凭证超时时间，单位（秒）,
    "refresh_token"=>"用户刷新access_token",
    "openid"=>"用户唯一标识",
    "scope"=>"用户授权的作用域，使用逗号（,）分隔")
     */
    public static function refreshToken($refreshToken,$appid){
        $queryUrl = self::wx_oauth2_refresh_token.'?appid='.$appid.'&grant_type=refresh_token&refresh_token='.$refreshToken;
        $queryAction = 'GET';
        return CurlHelper::callWebServer($queryUrl, '', 'get');
    }

    /**
     * 拉取用户信息(需scope为 snsapi_userinfo)
     * 如果网页授权作用域为snsapi_userinfo，则此时开发者可以通过access_token和openid拉取用户信息了。
     * @param $accessToken 网页授权接口调用凭证。通过本类的第二个方法getAccessTokenAndOpenId可以获得一个数组，数组中有一个字段是access_token，就是这里的参数。注意：此access_token与基础支持的access_token不同
     * @param $openId 用户的唯一标识
     * @param $lang 返回国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语
     *
     * @return array("openid"=>"用户的唯一标识",
    "nickname"=>'用户昵称',
    "sex"=>"1是男，2是女，0是未知",
    "province"=>"用户个人资料填写的省份"
    "city"=>"普通用户个人资料填写的城市",
    "country"=>"国家，如中国为CN",
    //户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），用户没有头像时该项为空
    "headimgurl"=>"http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46",
    //用户特权信息，json 数组，如微信沃卡用户为chinaunicom
    "privilege"=>array("PRIVILEGE1", "PRIVILEGE2"),
    );
     */
    public static function getUserInfo($accessToken, $openId, $lang='zh_CN'){
        $queryUrl = self::wx_oauth2_get_userinfo.'?access_token='. $accessToken . '&openid='. $openId .'&lang=zh_CN';
        return CurlHelper::callWebServer($queryUrl, '', 'get');
    }

}