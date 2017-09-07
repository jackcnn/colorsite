<?php
/**
 * Date: 2017/8/30 0030
 * Time: 16:31
 */
namespace backend\controllers;

use Yii;
use yii\web\Controller;
class BaseController extends Controller
{
    public function _post($name = null ,$defaultValue = null )
    {
        return \Yii::$app->request->post($name ,$defaultValue);
    }
    public function _get($name = null ,$defaultValue = null )
    {
        return \Yii::$app->request->get($name ,$defaultValue);
    }
    public function _request()
    {
        return \Yii::$app->request;
    }
    public function success($msg='',$router='')
    {
        if($msg){
             echo \Yii::$app->session->setFlash('AlertMsg',$msg,false);
        }
        if(!$router){
            $router = self::_request()->absoluteUrl;
        }

        $this->redirect($router);
    }
}