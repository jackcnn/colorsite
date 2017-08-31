<?php
/**
 * Date: 2016/7/27
 * Time: 14:37
 * 微信助手类
 */
namespace common\weixin;

use common\models\table\Web;
use yii\helpers\CurlHelper;
use common\weixin\Wxoauth2Helper;
use common\weixin\WxqrcodeHelper;
use common\weixin\WxCommon;
use yii\helpers\UHelper;

class WeixinHelper extends WxCommon
{

    //const wx_access_token='https://api.weixin.qq.com/cgi-bin/token';

    const wx_menu_create='https://api.weixin.qq.com/cgi-bin/menu/create';

    const wx_menu_delete='https://api.weixin.qq.com/cgi-bin/menu/delete';


    public static function getAccessToken($wid){

           return  self::accessToken($wid);

    }

    /*
     * 获取access_token
     * */
    public static function accessToken111($wid)
    {
        $access_token=\Yii::$app->cache->get('wx_access_token_'.$wid);
        if($access_token){
            return $access_token;
        }else{
            $model=Web::findOne($wid);

            $parame['grant_type']='client_credential';

            if($model->wx_use){
                $parame['appid']=$model->wx_appid;
                $parame['secret']=$model->wx_appsecret;
            }else{
                $newmodel=Web::findOne(ADMIN_WID);

                $parame['appid']=$newmodel->wx_appid;
                $parame['secret']=$newmodel->wx_appsecret;
            }

            $return=CurlHelper::callWebServer(self::wx_access_token,$parame);

            \Yii::$app->cache->set('wx_access_token_'.$wid,$return['access_token'],intval($return['expires_in']-200));
            \Yii::$app->cache->set('wx_appid_'.$wid,$parame['appid']);
            \Yii::$app->cache->set('wx_appsecret_'.$wid,$parame['secret']);
            return $return['access_token'];
        }
    }

    /*
     * 根据wid获取后台web的微信配置信息
     * */
    public static function getWxInfo($wid)
    {
        if(($model = Web::findOne($wid)) !== null){
            return $model;
        }else{
            return Web::findOne(ADMIN_WEBID);
        }
    }


    /*
     * 新建自定义菜单
     * url:wx_menu_create
     * */
    public static function menuCreate($data,$wid)
    {
        $url=self::wx_menu_create.'?access_token='.self::accessToken($wid);
        $return=CurlHelper::callWebServer($url,$data,'post');
        return $return;
    }

    /*
     * 删除自定义菜单
     * url:wx_menu_delete
     * */
    public static function menuDelete($wid)
    {
        $url=self::wx_menu_delete.'?access_token='.self::accessToken($wid);
        $return=CurlHelper::callWebServer($url,'','get');
        return $return;
    }

    /*
     * 微信网页授权
     * */
    public static function oauth2($wid,$userinfo=false,$accept_cache=true)
    {
        $scope=$userinfo?'snsapi_userinfo':'snsapi_base';


        $request  = \Yii::$app->request;
        $response = \Yii::$app->response;
        $cache    = \Yii::$app->cache;

        /*
         *是否使用缓存，在确认需要获取用户最新的信息的时候需要设置为false
         * */
        if($accept_cache){

            $openid_cookies= \Yii::$app->request->cookies->get('wxoauth2_'.$scope.$wid);

            /*
             * openid 缓存还在的时候直接返回
             * */
            if($openid_cookies && $cache->get('wxoauth2_'.$wid.'_'.$openid_cookies->value)){
                return $openid_cookies->value;
            }
        }



        $model= Web::findOne($wid);

        if($model->wx_use){
            $appid=$model->wx_appid;
            $appsecret=$model->wx_appsecret;
        }else{
            $default=Web::findOne(1);
            $appid=$default->wx_appid;
            $appsecret=$default->wx_appsecret;
        }


        /*
         * 用户同意授权
         * */
        if($request->get('code')){


            $base_info=Wxoauth2Helper::getTokenAndOpenid($request->get('code'),$appid,$appsecret);

            $openid=$base_info['openid'];


            if($openid){

                $oauth2_info=\common\models\table\Oauth2::find()->where(['openid'=>$openid])->one();

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
                    $oauth2_new_info=new \common\models\table\Oauth2();
                    $oauth2_new_info->wid=$wid;
                    $oauth2_new_info->openid=$openid;
                    $oauth2_new_info->encrypt=$encrypt;
                    $oauth2_new_info->save();
                }

                /*
                 * 需要拿用户的信息的时候，把用户信息更新到数据库中oauth2
                 * */
                if($scope=='snsapi_userinfo'){

                    $user_info=Wxoauth2Helper::getUserInfo($base_info['access_token'],$base_info['openid']);


                    $oauth2_info=\common\models\table\Oauth2::find()->where(['openid'=>$openid])->one();

                    $oauth2_info->wxname=$user_info['nickname'];
                    $oauth2_info->wxpic=$user_info['headimgurl'];
                    $oauth2_info->sex =$user_info['sex'];
                    $oauth2_info->province=$user_info['province'];
                    $oauth2_info->city=$user_info['city'];
                    $oauth2_info->country=$user_info['country'];
                    $oauth2_info->privilege=json_encode($user_info['privilege']);
                    $oauth2_info->unionid=isset($user_info['unionid'])?$user_info['unionid']:'';
                    $oauth2_info->save();
                }
            }else{
                return false;
            }

            \Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'wxoauth2_'.$scope.$wid,
                'value' => $openid,
            ]));

            $cache->set('wxoauth2_'.$wid.'_'.$openid,$openid,7000);

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
    public static function openidInfo($openid,$wid=0){

        $model=\common\models\table\Oauth2::find()->where(['openid'=>$openid])->asArray()->one();

        return $model!==null?$model:[];
    }

    /*
     * 根据openid 拿数据，必须关注公众号或者在公众号页面内才行
     * */
    public static function accessGetInfo($openid,$wid){
        $accessToken=self::accessToken($wid);

        $link="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$accessToken."&openid=".$openid."&lang=zh_CN";

        $return=CurlHelper::callWebServer($link,'','get');

        return $return;
    }


    /*
     * 生成临时二维码
     * */
    public static function createQrcode($wid , $sceneId , $expireSeconds,$box=[0,0])
    {
        $accessToken=self::accessToken($wid);

        $ticket_info=WxqrcodeHelper::createTicket($sceneId , $expireSeconds ,$accessToken);

        $dirNo = 'x' . sprintf("%05d", $wid) . '/';

        $month = date("Ym", time()) . '/';

        $name = date('dHis',time()).substr(md5($sceneId),8,8).'.png';

        $outfile = \Yii::getAlias('@upload') . '/' . $dirNo . 'wxcode' . '/' . $month . $name;

        WxqrcodeHelper::creatQrimg($ticket_info['url'],$outfile,$box);

        return \Yii::getAlias('@uploadreturn') . '/' . $dirNo . 'wxcode' . '/' . $month . $name;

    }

    /*
     * 生成永久二维码
     * $sceneStr 二维码参数字段
     * */
    public static function createLimitQrcode($wid , $sceneStr='' , $sceneId='',$box=[0,0])
    {
        $accessToken=self::accessToken($wid);


        $ticket_info=WxqrcodeHelper::createLimitTicket($sceneStr,$sceneId,$accessToken);

        $dirNo = 'x' . sprintf("%05d", $wid) . '/';

        $month = date("Ym", time()) . '/';

        $name = date('dHis',time()).substr(md5($sceneId),8,8).'.png';

        $outfile = \Yii::getAlias('@upload') . '/' . $dirNo . 'wxcodelimit' . '/' . $month . $name;

        WxqrcodeHelper::creatQrimg($ticket_info['url'],$outfile,$box);

        return \Yii::getAlias('@uploadreturn') . '/' . $dirNo . 'wxcodelimit' . '/' . $month . $name;

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
    public static function checkSignature($wid)
    {
        $model=\common\models\table\Web::findOne($wid);
        $request=\Yii::$app->request;
        $signature = $request->get('signature');
        $timestamp = $request->get('timestamp');
        $nonce = $request->get('nonce');
        $token = $model->wx_token;
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