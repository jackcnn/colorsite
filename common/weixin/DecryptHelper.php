<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/19 0019
 * Time: 11:41
 */
namespace common\weixin;

use common\weixin\WxCommon;
use yii\helpers\CurlHelper;

use common\weixin\lib\endecrypt\DecryptbaseHelper;
use yii\helpers\UHelper;

class DecryptHelper extends WxCommon
{
    /*
     * 解密微信小程序微信运动数据
     * $data 加密的数据
     * $aesKey 小程序登录sessionKey
     * $appid 小程序appid
     * $appid='wx0bdbb4ff7739ce86';
     * $encryptedData="GYAoP8ZXwVU8ZJMfoJNpcBAoWPEzX5bXX3sgdKWM57e088WVmxRZ3BOnDXYDetqi6ltP1d9/Ve3tHallmowO344w5auyglu6v3SQnSyisAZ7p0EpfTtwyqfA1L+nIMyBBTVbtroG8nTOOFvIcbNCpy+rgOFYKX1F4DpPW9RINVCCH5VQD5sAwhm9NdvmXPyEWCZ24PHPx9/1fiHi+A2D0ibRdOB4OrgbheYpchUxgrYxWIXEiCVRtciywM0Szjuif4cTNBpnw3nqefNV/ztKmoqUkf0HPQ+F6rw5RnI2r+GQRz39eOr0PUTOI0PhZvT37Rtg++SSl5+xvLjv9RZCFc96Czdc5+DkP/NgbzgXKE4y+aXNP4xdT5yuqZJTCAmTEpO5hmC0U/yMZsngc5N/LvjL4cSgzH8kK745JtVbTDeqp8UPwNCYQdPARLxAbCBLmybqYTa1mRFHXgdf2LotwN9zp3RikK+u4CZPoIddzPTythhI0kDtuU55i/gfqGHB7PdqaCcB2aYYkQhbmaaMjLjqTmFhWf2jIpLy8NY5DK26zwgzG+oh52OvBklryQ4oApRsIXq347TUGWSlVTtppA848LjBwPSdPu9M0y2tlNOra+K3TBPnrAGwXjqeO9yJc0mbO8yFTebHCpoIgJQfD4VN0VK1PkXfYUTQepEkdPenh+YklxcMKR+11l31EzwItfTiCFfx4uxcttEyCP3KWRUjZGe8ovLbxo2gQFCRR2I4Zo6U7yu2iMo6uYlnojADvTF3yxoOpXWt0eC8XD8o9BzJpu7ddvOaHf5fYCIYod0dXUCNiOM84DhM8cl5ViKNWdnTIOch1wzCJ1JN5cuvkgO4Xru/Rdrs43OmxWqXuh9r3+G+cOwyqJbVvH/iIi48GjbC2e60sjGT0mC/T+DksQP1QIY3QOxnxzmNikAIAH0xmu8R0+NSzKRCnqiLqXDdGDnsfBOZtFEURLgq5m0wokTpnieb7LKxUEBPopirfG2+1Y99l/1pPMRGEOrjdRI3tbRMORNm6L+I07mPZ0YdAzU1b2+A95UyWvPDPoxDaR0BxxlMyIiZn1ta0qXpSBhc4tJst6KWVXmpxk3UdOlrMrDx8ohm8B0UtGNHLb32Qn+SJ/3YWBvVLkzR2ArnF7DQuKse3Vd6verSlmTrdkj/hcugZ5IpedQafPiVG3xzOil5+RM9KRwGxowXGDRWhZMdz8OsQ4wCN3f9T26BOMEOG4fwZTSOl2LC1x0nN1rrJSFQGmFDQQEsWxerLwONLqO3v7/nc6OVpmnHeNnlrOXnx6sOpsa0KEqO4tZJjxFvW62tfYH9XeS6MpJEakXLngzOXKhsIyIjwn2wEuEWExPr+xI5FFNClHSBXrypQbXUo1xwQbKOujtP0l1wT127TM473dnJ43FfMMJ2sznLLtA7KJuRFIujnayFD2ShwxCN402P+u9B+gmpMcMLdiRI4UffuO8mS6eLp4qiQ2dPR5f0mzVyfO+25Cvnk40tMTIYf1jJX2XhBHt2gWmjHtL3NKnuGNFZFO7NSUIPHVCgjksdbaUaSBs3LJbYx66IAHMCUkfS/aZPxNwgA+3LepO6Fd0H1+ZH6wFNrNVU+1SJaSmQx3E+uylNXNrgmYTYyB0Nvco=";
     * $iv="tb80KD82ODyF1qNYHwPfiA==";
     * $sessionKey="t82x6riU7SQ3xb7u20gF3Q==";
     * $pc = \common\weixin\DecryptHelper::wxrun_decrypt($encryptedData,$sessionKey,$iv ,$appid);
     * */
    public static function wxrun_decrypt($encryptedData,$aesKey,$iv ,$appid){

        $encryptedData = trim($encryptedData);
        $aesKey = trim($aesKey);
        $iv = trim($iv);
        $appid = trim($appid);

        $return['success'] = true;
        try{
            if (strlen($aesKey) != 24) {
                throw new \Exception('非法sessionkey');
            }
            $aesKey=base64_decode($aesKey);

            if (strlen($iv) != 24) {
                throw new \Exception('非法iv向量');
            }

            $aesIV=base64_decode($iv);

            $aesCipher=base64_decode($encryptedData);

            $pc = new DecryptbaseHelper($aesKey);

            $result = $pc->decrypt($aesCipher,$aesIV);

            if ($result[0] != 0) {
                throw new \Exception($result[0]);
            }

            $dataObj=json_decode( $result[1] );

            if( $dataObj  == NULL )
            {
                throw new \Exception('aes解密失败00');
            }
            if( $dataObj->watermark->appid != $appid )
            {
                throw new \Exception('aes解密失败01');
            }
            $return['data'] = $result[1];
        }catch (\Exception $e){
            $return['success'] = false;
            $return['data'] = $e->getMessage();
        }
        return $return;
    }

    /*
     * 退款回调通知解密-- 还没有做好的
     * */
    public static function refund_notify_decrypt($encryptedData,$aesKey)
    {
        $encryptedData = trim($encryptedData);
        $aesKey = trim($aesKey);

        $return['success'] = true;
        try{
            if (strlen($aesKey) != 24) {
                //throw new \Exception('非法sessionkey');
            }
            $aesKey=base64_decode($aesKey);

            $aesCipher=base64_decode($encryptedData);

            $pc = new DecryptbaseHelper($aesKey);

            $result = $pc->decrypt($aesCipher,'','aes-256-ecb');

            if ($result[0] != 0) {
                throw new \Exception($result[0]);
            }

            $dataObj=json_decode( $result[1] );

            if( $dataObj  == NULL )
            {
                throw new \Exception('aes解密失败00');
            }
            $return['data'] = $result[1];
        }catch (\Exception $e){
            $return['success'] = false;
            $return['data'] = $e->getMessage();
        }
        return $return;

    }



}