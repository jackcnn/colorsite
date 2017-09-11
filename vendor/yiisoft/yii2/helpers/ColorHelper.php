<?php
/**
 * Date: 2016/7/8
 * Time: 14:33
 */
namespace yii\helpers;
use yii\base\NotSupportedException;

/**
 *自己写的helper
 *
 */
class ColorHelper
{
    /*
     * 原有输出数据
     * */
    public static function dump($data,$print=true)
    {
        header("Content-type: text/html; charset=utf-8");
        echo '<pre>';
            if($print){
                print_r($data);
            }else{
                var_dump($data);
            }
        echo '</pre>';
    }
    /*
     * 生成订单号
     * $id 标识
     * */
    public static function orderSN($id)
    {
        return date('YmdHis',time()).sprintf("%05d",$id ).substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 4);
    }
    /*
     * 根据字符生成token,不可逆转
     * $data 标识数据
     * */
    public static function createToken($data)
    {
        $token = $data.'ColorSiteSolts';
        return strtoupper(md5(md5($token).'C1o2l3o4r5S6i7t8e9S10o11l12t13s14'));
    }
    /*
     * request
     * */
    public static function request()
    {
        return \Yii::$app->request;
    }

    /*
     * 微信oauth2授权登录
     * $router,url::to() 中的数组第一个值
     * $relogin 强制进入授权
     * */
    public static function wxlogin($wid=1,$router="index",$relogin=false){

        $model=\common\models\table\Web::find($wid)->one();

        $user=\Yii::$app->user;
        $request=\Yii::$app->request;

        /*
         * 本地测试的时候直接登录，不要微信授权了
         * */
        if(0){
            $identity=\frontend\models\Member::findIdentity(5);
            \Yii::$app->user->login($identity,3600*24*7);
            return;
        }

        if($user->isGuest || $relogin){
            $code=$request->get('code');
            $state=$request->get('state');
            if(!isset($code) && !isset($state)) {//微信页面授权--!isset($code) && !isset($state)
                return \common\weixin\Wxoauth2Helper::getcode($request->absoluteUrl,$model->wx_appid,'snsapi_userinfo');
            }else{
                $oauth_info=\common\weixin\Wxoauth2Helper::getTokenAndOpenid($code,$model->wx_appid,$model->wx_appsecret);
                if(isset($oauth_info['access_token'])){
                    $user_info=\common\weixin\Wxoauth2Helper::getUserInfo($oauth_info['access_token'],$oauth_info['openid']);
                }else{//重新拿code
                    $querys=$request->get();
                    unset($querys['code']);
                    unset($querys['state']);
                    array_unshift($querys,$router);
                    $url=Url::to($querys,true);
                    return \Yii::$app->getResponse()->redirect($url)->send();
                }

                //可以拿到微信信息了
                $member=\frontend\models\Member::find()->where(['openid'=>$user_info['openid']])->one();
                if(!$member){
                    $member=new \frontend\models\Member();
                    $member->auth_key=\Yii::$app->security->generateRandomString();
                }

                $member->access_token=\Yii::$app->security->generateRandomString();
                $member->openid=$user_info['openid'];
                $member->wid=$wid;
                $member->name=$user_info['nickname'];
                $member->oa_name=$user_info['nickname'];
                $member->oa_avatar=$user_info['headimgurl'];
                $member->isactive=1;

                if($member->save()){
                    $oauth2=\common\models\table\Oauth2::find()->where(['memberid'=>$member->id])->one();
                    if(!$oauth2){
                        $oauth2=new \common\models\table\Oauth2();
                    }
                    $oauth2->memberid=$member->id;
                    $oauth2->wid=$wid;
                    $oauth2->type='wx';
                    $oauth2->name=urlencode($user_info['nickname']);
                    $oauth2->openid=$user_info['openid'];
                    $oauth2->avatar=$user_info['headimgurl'];
                    $oauth2->sex=$user_info['sex'];
                    $oauth2->province=$user_info['province'];
                    $oauth2->city=$user_info['city'];
                    $oauth2->country=$user_info['country'];
                    $oauth2->unionid=isset($user_info['unionid'])?$user_info['unionid']:'unionid';
                    $oauth2->privilege=Json::encode($user_info['privilege']);
                    if($oauth2->save()){
                        $identity=\frontend\models\Member::findIdentity($member->id);
                        \Yii::$app->user->login($identity,3600*24*7);
                    }else{
                        //echo current($oauth2->getFirstErrors());
                        exit('error:897');
                    }
                }else{
                    exit('error:547');
                }
            }

        }else{
            $identity=\Yii::$app->user->identity;
        }
    }

}