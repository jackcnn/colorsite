<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2017/4/16
 * Time: 23:05
 * 公共类
 */
namespace common\weixin;

use yii\helpers\CurlHelper;

class WxCommon {

    const wx_access_token='https://api.weixin.qq.com/cgi-bin/token';

    public static function accessToken($wid=1,$getinfo=false){

        $access_token=\Yii::$app->cache->get('wx_access_token_'.$wid);

        if(!$access_token){
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
            //return $return['access_token'];
            $access_token=$return['access_token'];
            $appid= $parame['appid'];
            $appsecret =$parame['secret'];

        }else{

            if($getinfo){
                $appid= \Yii::$app->cache->get('wx_appid_'.$wid);
                $appsecret =\Yii::$app->cache->get('wx_appsecret_'.$wid);
            }else{
                $appid= '';
                $appsecret ='';
            }
        }
        $appinfo['access_token']=$access_token;
        $appinfo['appid']=$appid;
        $appinfo['appid']=$appid;
        return $getinfo?$appinfo:$access_token;
    }

    public static function createSign($data,$mch_key){
        //签名步骤一：按字典序排序参数
        ksort($data);

        $buff = "";
        foreach ($data as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        //签名步骤二：在string后加入KEY
        $string = $buff . "&key=".$mch_key;

        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

}