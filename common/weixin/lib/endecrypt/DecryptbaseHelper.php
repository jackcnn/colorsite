<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/19 0019
 * Time: 11:49
 */
namespace common\weixin\lib\endecrypt;

use common\weixin\lib\endecrypt\PKCS7EncoderHelper;
use yii\helpers\UHelper;


class DecryptbaseHelper
{
    public $key;

    function __construct( $k )
    {
        $this->key = $k;
    }

    /**
     * 对密文进行解密
     * @param string $aesCipher 需要解密的密文
     * @param string $aesIV 解密的初始向量
     * @param string method |aes-128-cbc, aes-256-cbc ,aes-256-ecb
     * @return string 解密得到的明文
     */
    public function decrypt( $aesCipher, $aesIV = '' ,$method ='aes-128-cbc')
    {

        try {

            $decrypted = openssl_decrypt($aesCipher, $method , $this->key, true, $aesIV);

            echo '888888';
            UHelper::dump($this->key);
            echo '******';


        } catch (Exception $e) {

            return array('aes 解密失败000', null);

        }

        try {
            //去除补位字符
            $pkc_encoder = new PKCS7EncoderHelper;
            $result = $pkc_encoder->decode($decrypted);

        } catch (Exception $e) {
            //print $e;
            return array('aes 解密失败001', null);
        }
        return array(0, $result);

    }

}