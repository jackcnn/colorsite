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
use common\models\Thirdcfg;
use yii\web\HttpException;

class WxCommon {

    const wx_access_token='https://api.weixin.qq.com/cgi-bin/token';

    public static function getconfig($owid)
    {
        return Thirdcfg::find()->where(['ownerid'=>$owid,'type'=>'weixin'])->asArray()->one();
    }
    /*
     * 所有的accessToken都必须使用这个函数获取
     * */
    public static function accessToken($owid=ADMIN_OWID)
    {
        $cache = \Yii::$app->cache;
        $accessToken = $cache->get("wxAccessToken".$owid);
        if(!$accessToken){
            $config = self::getconfig($owid);
            $parame['grant_type']='client_credential';
            if($config['isuse']>0){
                $parame['appid']=$config['appid'];
                $parame['secret']=$config['appsecret'];
            }else{
                $new_config=self::getconfig(ADMIN_OWID);
                $parame['appid']=$new_config['appid'];
                $parame['secret']=$new_config['appsecret'];
            }
            $return=CurlHelper::callWebServer(self::wx_access_token,$parame);
            if(isset($return['access_token']) && isset($return['expires_in'])){
                $cache->set('wxAccessToken'.$owid,$return['access_token'],intval($return['expires_in']-200));
            }else{
                throw new HttpException('access token 获取失败！');
            }
            $accessToken = $return['access_token'];
        }
        return $accessToken;
    }

    public static function createSign($data,$mch_key)
    {
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