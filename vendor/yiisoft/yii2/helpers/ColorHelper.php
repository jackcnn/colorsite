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
        return date('ymdHis',time()).sprintf("%05d",$id ).substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 4);
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
     * 根据ID 生成字符串
     * */
    public static function id2token($id)
    {
        $helper= new \yii\helpers\Id2TokenHelper();
        return $helper->encode($id);
    }
    public static function token2id($token)
    {
        $helper= new \yii\helpers\Id2TokenHelper();
        return $helper->decode($token);
    }
    public static function log($behavior,$info=[])
    {
        $model = new \common\models\BehaviorLog();
        $model->userid = \Yii::$app->user->identity->getId()?\Yii::$app->user->identity->getId():0;
        $model->ip = \Yii::$app->request->getUserIP();
        $model->behavior = $behavior;
        $model->info = json_encode($info);
        $model->save();
    }
    public static function alert($msg)
    {
        \Yii::$app->session->setFlash('AlertMsg',$msg);
    }
    public static function err($msg)
    {
        \Yii::$app->session->setFlash('ErrMsg',$msg);
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
    public static function wxlogin($ownerid,$router="index",$relogin=false){



        $model = \common\models\Thirdcfg::find()->where(['ownerid'=>$ownerid,'type'=>'weixin'])->one();

        $user=\Yii::$app->user;
        $request=\Yii::$app->request;

        /*
         * 本地测试的时候直接登录，不要微信授权了
         * */
        if(0){
            $identity=\frontend\models\MemberAccess::findIdentity(2);
            \Yii::$app->user->login($identity,3600*24*7);
            return;
        }

        if($relogin||$user->isGuest){

            $code=$request->get('code');
            $state=$request->get('state');


            if(!isset($code) && !isset($state)) {//微信页面授权--!isset($code) && !isset($state)

                return \common\weixin\Wxoauth2Helper::getcode($request->absoluteUrl,$model->appid,'snsapi_userinfo');
            }else{

                $oauth_info=\common\weixin\Wxoauth2Helper::getTokenAndOpenid($code,$model->appid,$model->appsecret);

                if(isset($oauth_info['access_token'])){
                    $user_info=\common\weixin\Wxoauth2Helper::getUserInfo($oauth_info['access_token'],$oauth_info['openid']);
                }else{//重新拿code
                    $querys=$request->get();
                    unset($querys['code']);
                    unset($querys['state']);
                    array_unshift($querys,$router);
                    $url=Url::to($querys,true);
                    \Yii::$app->getResponse()->redirect($url)->send();die;
                }



                //可以拿到微信信息了
                $member=\frontend\models\MemberAccess::find()->where(['openid'=>$user_info['openid']])->one();
                if(!$member){
                    $member=new \frontend\models\MemberAccess();
                    $member->auth_key=\Yii::$app->security->generateRandomString();
                }

                $member->access_token=\Yii::$app->security->generateRandomString();
                $member->openid=$user_info['openid'];
                $member->ownerid=$ownerid;
                $member->name=$user_info['nickname'];
                $member->wxname=$user_info['nickname'];
                $member->wxpic=$user_info['headimgurl'];
                $member->wxinfo = json_encode($user_info);

                if($member->validate() && $member->save()){
                    $identity=\frontend\models\MemberAccess::findIdentity($member->id);
                    \Yii::$app->user->login($identity,3600*24*7);
                }else{
                    die('登陆失败，请重试'.current($member->getFirstErrors()));
                }
            }

        }else{
            $identity=\Yii::$app->user->identity;
        }


    }

}