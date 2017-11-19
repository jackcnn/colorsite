<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/15 0015
 * Time: 11:29
 */
namespace frontend\controllers;

use common\weixin\WeixinHelper;
use Faker\Provider\Color;
use Yii;
use frontend\controllers\BaseController;
use yii\helpers\ArrayHelper;
use yii\helpers\ColorHelper;
use yii\helpers\CurlHelper;
use yii\helpers\Url;
use common\models\Baoming;

class IndexController extends BaseController
{

    public $enableCsrfValidation = false;

    public $appid = "wx5c129bb7c615a146";
    public $appsecret = "75d5dc704944c1808dee2b4e17dcdd05";

    //登陆
    public function actionLogin($code)
    {
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$this->appid."&secret=".$this->appsecret."&js_code=".$code."&grant_type=authorization_code";
        $res = CurlHelper::callWebServer($url);
        return $this->asJson($res);
    }

    //信息提交
    public function actionSubmit()
    {
        $asJson['success'] = true;
        try{
            $tel = \Yii::$app->request->post("tel");
            $ways = \Yii::$app->request->post("ways");
            $desc  = \Yii::$app->request->post("desc");
            $openid = \Yii::$app->request->post("openid");

            $check = Baoming::find()->where(['tel'=>$tel])
                ->andWhere(['>',"created_at",time()-3600])->count();
            if($check){
                throw new \Exception('手机号已提交过了');
            }
            $check1 = Baoming::find()->where(['ip'=>$openid])
                ->andWhere(['>',"created_at",time()-3600])->count();
            if($check1){
                throw new \Exception('操作过于频繁');
            }

            $model = new Baoming();
            $model->name = "tbk-submit";
            $model->tel = $tel;
            $model->func = json_encode(['ways'=>$ways,'desc'=>$desc]);
            $model->ip= $openid;
            if($model->validate() && $model->save()){
                $asJson['msg'] = '提交成功！';
            }else{
                $asJson['msg'] = current($model->getFirstErrors());
            }
        }catch (\Exception $e){
            $asJson['success'] = false;
            $asJson['msg'] = $e->getMessage();
        }
        return $this->asJson($asJson);
    }

    public function actionIndex()
    {

        $url = "https://api.ai.qq.com/fcgi-bin/nlp/nlp_texttrans";

        $params['app_id'] = 1106539758;
        $params['time_stamp'] = intval(time());
        $params['nonce_str'] = \Yii::$app->security->generateRandomString(16);
        $params['type'] = \Yii::$app->request->post("type");
        $params['text'] = \Yii::$app->request->post("text");

        $sign = self::getSign($params);

        $params['sign'] = $sign;

        $res = CurlHelper::callWebServer($url,$params,"post",true,false);

        return $this->asJson($res);

    }

    public static function getSign($Obj,$appkey="ktq1vUBOBSM3FyLt")
    {
        foreach ($Obj as $k => $v)
        {
            $Parameters[$k] = urlencode($v);
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
        $String = $reqPar."&app_key=".$appkey;

        //签名步骤三：MD5加密
        $String = md5($String);
        //echo "【string3】 ".$String."</br>";
        //签名步骤四：所有字符转为大写
        $result = strtoupper($String);
        //echo "【result】 ".$result_."</br>";
        return $result;
    }

}