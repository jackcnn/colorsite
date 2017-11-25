<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/25 0025
 * Time: 18:47
 */
namespace frontend\modules\dish\controllers;

use common\models\Clerk;
use Yii;
use frontend\controllers\BaseController;
use yii\helpers\ColorHelper;

class TemplateController extends BaseController
{

    public $enableCsrfValidation = false;

    public function actionIndex($store_id,$clerk_id)
    {

        $request = \Yii::$app->request;
        if($request->isPost){
            $asJson['success'] = true;

            try{
                $model = Clerk::findOne($clerk_id);

                if($model->public_openid){
                    throw new \Exception('二维码已被绑定了');
                }
                $model->public_openid = $request->post('openid');
                if($model->validate() && $model->save()){
                    $asJson['msg'] = '绑定成功！';
                }else{
                    throw new \Exception(current($model->getFirstErrors()));
                }

            }catch (\Exception $e){
                $asJson['success'] = false;
                $asJson['msg'] = $e->getMessage();
            }
            return $this->asJson($asJson);
        }else{
            $openid=self::wxlogin();
        }

        return $this->renderPartial('index',['openid'=>$openid]);
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
                array_unshift($query,"index");
                $url=Url::to($query,true);
                \Yii::$app->getResponse()->redirect($url)->send();die;
            }

        }
    }

}