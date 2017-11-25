<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/25 0025
 * Time: 18:47
 */
namespace frontend\modules\dish\controllers;

use Yii;
use frontend\controllers\BaseController;
use yii\helpers\ColorHelper;

class TemplateController extends BaseController
{

    public function actionIndex()
    {
        $openid=self::wxlogin();
        echo $openid;

    }

    public static function wxlogin()
    {
        $request = \Yii::$app->request;
        $code=$request->get('code');
        $state=$request->get('state');


        if(!isset($code) && !isset($state)) {//微信页面授权--!isset($code) && !isset($state)

            return \common\weixin\Wxoauth2Helper::getcode($request->absoluteUrl,CHENGLAN_APPID,'snsapi_userinfo');
        }else{

            $oauth_info=\common\weixin\Wxoauth2Helper::getTokenAndOpenid($code,CHENGLAN_APPID,CHENGLAN_APPSECRET);

            if(isset($oauth_info['openid'])){
                return $oauth_info['openid'];
            }else{//重新拿code
                $query=$request->get();
                unset($query['code']);
                unset($query['state']);
                array_unshift($query,$router);
                $url=Url::to($query,true);
                \Yii::$app->getResponse()->redirect($url)->send();die;
            }

        }
    }

}