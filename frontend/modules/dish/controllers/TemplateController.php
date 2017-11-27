<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/25 0025
 * Time: 18:47
 */
namespace frontend\modules\dish\controllers;

use common\models\Dishreceive;
use Yii;
use frontend\controllers\BaseController;
use yii\helpers\ColorHelper;
use yii\helpers\Url;

class TemplateController extends BaseController
{

    public $enableCsrfValidation = false;

    public function actionIndex($store_id,$id)
    {
        $request = \Yii::$app->request;
        if($request->isPost){

            $asJson['success'] = true;
            try{

                $count = Dishreceive::find()->where(['store_id'=>$store_id,'openid'=>$request->post('openid')])->count();

                if($count){
                    throw new \Exception('一个门店只能绑定唯一的微信号！');
                }

                $model = Dishreceive::findOne($id);

                if($model->openid){
                    throw new \Exception('二维码已被绑定了');
                }
                $model->openid = $request->post('openid');
                $model->wxname = urlencode($request->post('wxname'));
                $model->wxpic = $request->post('wxpic');

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
            $res=self::wxlogin();

        }
        return $this->renderPartial('index',['res'=>$res]);
    }

    public function actionSetreceive()
    {

        $request = \Yii::$app->request;
        if($request->isPost){
            $list = $request->post('list');
            $openid = $request->post('openid');
            $asJson['success'] = true;
            try{

                if(count($list)){
                    foreach ($list as $key=>$value){
                        $data = explode('-',$value);
                        $model = Dishreceive::find()->where(['id'=>$data[0],'openid'=>$openid])->one();
                        $model->is_receive = $data[1];
                        if(!$model->save()){
                            throw new \Exception(current($model->getFirstErrors()));
                        }
                    }
                    $asJson['msg'] = '修改成功！';
                }
            }catch (\Exception $e){
                $asJson['success'] = false;
                $asJson['msg'] = $e->getMessage();
            }
            return $this->asJson($asJson);
        }else{
            $res=self::wxlogin();
//            $res['openid'] = "oygRU07sg52dl3y6RPIpbDXrZC-g";
            $list = Dishreceive::find()->join("left join","{{%stores}}","{{%stores}}.id={{%dishreceive}}.store_id")
                ->select("{{%dishreceive}}.*,{{%stores}}.name as storeName")
                ->where(['openid'=>$res['openid']])
                ->asArray()
                ->all();

        }
        return $this->renderPartial('setreceive',['res'=>$res,'list'=>$list]);

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
                $user_info=\common\weixin\Wxoauth2Helper::getUserInfo($oauth_info['access_token'],$oauth_info['openid']);

                $res['openid'] = $oauth_info['openid'];
                $res['wxname'] = $user_info['nickname'];
                $res['wxpic'] = $user_info['headimgurl'];
                return $res;
            }else{//重新拿code
                $query=$request->get();
                unset($query['code']);
                unset($query['state']);
                array_unshift($query,"index");
                $url = Url::to($query,'https');
                \Yii::$app->getResponse()->redirect($url)->send();die;
            }

        }
    }

}