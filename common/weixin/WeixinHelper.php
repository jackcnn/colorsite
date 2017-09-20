<?php
/**
 * Date: 2016/7/27
 * Time: 14:37
 * 微信助手类
 */
namespace common\weixin;

use yii\helpers\CurlHelper;
use common\weixin\Wxoauth2Helper;
use common\weixin\WxqrcodeHelper;
use common\weixin\WxCommon;
use yii\helpers\FileHelper;
use yii\web\HttpException;

use common\models\Oauth2;

class WeixinHelper extends WxCommon
{

    const wx_menu_create='https://api.weixin.qq.com/cgi-bin/menu/create';

    const wx_menu_delete='https://api.weixin.qq.com/cgi-bin/menu/delete';

    /*
     * 新建自定义菜单
     * url:wx_menu_create
     * */
    public static function menuCreate($data,$owid)
    {
        $url=self::wx_menu_create.'?access_token='.self::accessToken($owid);
        $return=CurlHelper::callWebServer($url,$data,'post');
        return $return;
    }

    /*
     * 删除自定义菜单
     * url:wx_menu_delete
     * */
    public static function menuDelete($owid)
    {
        $url=self::wx_menu_delete.'?access_token='.self::accessToken($owid);
        $return=CurlHelper::callWebServer($url,'','get');
        return $return;
    }

    /*
     * 微信网页授权
     * */
    public static function oauth2($owid,$userinfo=false,$accept_cache=true)
    {
        $scope=$userinfo?'snsapi_userinfo':'snsapi_base';

        $request  = \Yii::$app->request;
        $response = \Yii::$app->response;
        $cache    = \Yii::$app->cache;
        /*
         *是否使用缓存，在确认需要获取用户最新的信息的时候需要设置为false
         * */
        if($accept_cache){
            $openid_cookies= $request->cookies->get('wxoauth2_'.$scope.$owid);
            /*
             * openid 缓存还在的时候直接返回
             * */
            if($openid_cookies){
                return $openid_cookies->value;
            }
        }

        $config = self::getconfig($owid);
        if($config['isuse']>0){
            $appid=$config['appid'];
            $appsecret=$config['appsecret'];
        }else{
            $new_config=self::getconfig(ADMIN_OWID);
            $appid=$new_config['appid'];
            $appsecret=$new_config['appsecret'];
        }

        /*
         * 用户同意授权
         * */
        if($request->get('code')){
            $base_info=Wxoauth2Helper::getTokenAndOpenid($request->get('code'),$appid,$appsecret);
            $openid=$base_info['openid'];
            if($openid){
                $oauth2_info=Oauth2::findOne(['openid'=>$openid]);
                /*
                 * 新增或者是修改oauth2表的encrypt
                 * */
                $parame=array('openid'=>$openid,'appid'=>$appid,'appsecret'=>$appsecret);
                $encrypt=self::getSign($parame);
                if($oauth2_info){
                    if(empty($oauth2_info->encrypt)){
                        $oauth2_info->encrypt=$encrypt;
                        $oauth2_info->save();
                    }
                }else{
                    $oauth2_new_info=new Oauth2();
                    $oauth2_new_info->owid=$owid;
                    $oauth2_new_info->openid=$openid;
                    $oauth2_new_info->encrypt=$encrypt;
                    /*
                     * 需要拿用户的信息的时候，把用户信息更新到数据库中oauth2
                     * */
                    if($scope=='snsapi_userinfo'){
                        $user_info=Wxoauth2Helper::getUserInfo($base_info['access_token'],$base_info['openid']);
                        $oauth2_new_info=Oauth2::findOne(['openid'=>$openid]);
                        $oauth2_new_info->name=$user_info['nickname'];
                        $oauth2_new_info->avatar=$user_info['headimgurl'];
                        $oauth2_new_info->sex =$user_info['sex'];
                        $oauth2_new_info->province=$user_info['province'];
                        $oauth2_new_info->city=$user_info['city'];
                        $oauth2_new_info->country=$user_info['country'];
                        $oauth2_new_info->privilege=json_encode($user_info['privilege']);
                        $oauth2_new_info->unionid=isset($user_info['unionid'])?$user_info['unionid']:'';
                    }
                    $oauth2_new_info->save();
                }
            }else{
                throw new HttpException('获取OPENID错误！');
            }
            $response->cookies->add(new \yii\web\Cookie([
                'name' => 'wxoauth2_'.$scope.$owid,
                'value' => $openid,
                'expire'=>time()+3600*24*7
            ]));
            return $openid;
        }else{
            /*
             * 跳转到授权页面
             * */
           return Wxoauth2Helper::getcode($request->absoluteUrl,$appid,$scope);
        }

    }

    /*
     * 根据openid查表拿信息，不一定是最新的，如需要最新要重新oauth2 不接受缓存授权
     * */
    public static function openidInfo($openid){
        return Oauth2::findOne(['openid'=>$openid]);
    }

    /*
     * 根据openid 拿数据，必须关注公众号或者在公众号页面内才行
     * */
    public static function accessGetInfo($openid,$owid){
        $accessToken=self::accessToken($owid);

        $link="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$accessToken."&openid=".$openid."&lang=zh_CN";

        return CurlHelper::callWebServer($link,'','get');
    }


    /*
     * 生成临时二维码
     * */
    public static function createQrcode($owid , $sceneId , $expireSeconds,$box=[0,0])
    {
        $accessToken=self::accessToken($owid);

        $ticket_info=WxqrcodeHelper::createTicket($sceneId , $expireSeconds ,$accessToken);

        $name = date('dHis',time()).substr(md5($sceneId),8,8).'.png';

        $dirNo = sprintf("%05d", $owid).'/wxqrcode';

        $path = FileHelper::createpath($dirNo,$name);

        $outfile = $path['abs'];

        WxqrcodeHelper::creatQrimg($ticket_info['url'],$outfile,$box);

        return $path['path'];

    }

    /*
     * 生成永久二维码
     * $sceneStr 二维码参数字段
     * */
    public static function createLimitQrcode($owid , $sceneStr='' , $sceneId='',$box=[0,0])
    {
        $accessToken=self::accessToken($owid);

        $ticket_info=WxqrcodeHelper::createLimitTicket($sceneStr,$sceneId,$accessToken);

        $name = date('dHis',time()).substr(md5($sceneId),8,8).'.png';

        $dirNo = sprintf("%05d", $owid).'/wxqrcode';

        $path = FileHelper::createpath($dirNo,$name);
        $outfile = $path['abs'];
        WxqrcodeHelper::creatQrimg($ticket_info['url'],$outfile,$box);
        return $path['path'];

    }


    /**
     * 	作用：生成签名
     */
    public static function getSign($Obj)
    {
        foreach ($Obj as $k => $v)
        {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $buff='';
        foreach ($Parameters as $k => $v)
        {
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0)
        {
            $reqPar = substr($buff, 0, strlen($buff)-1);
        }
        $String = $reqPar;
        //签名步骤三：MD5加密
        $String = md5($String);
        //echo "【string3】 ".$String."</br>";
        //签名步骤四：所有字符转为大写
        $result = strtoupper($String);
        //echo "【result】 ".$result_."</br>";
        return $result;
    }

    /*
     * 微信接入
     * */
    public static function checkSignature($owid)
    {
        $model=self::getconfig($owid);
        $request=\Yii::$app->request;
        $signature = $request->get('signature');
        $timestamp = $request->get('timestamp');
        $nonce = $request->get('nonce');
        $token = $model->api_token;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    /*
     * 根据记录生成微信菜单按钮
     * */
    public static function cbutton($data){
        $button=[];
        $button['name']=$data['name'];
        $button['type']=$data['type'];
        $button['key'] = $data['id'];
        $button['url']= $data['url'];
        $button['media_id']= $data['media_id'];
        $button['appid'] = $data['appid'];
        $button['pagepath'] = $data['pagepath'];
        return $button;
    }
}