<?php
namespace backend\controllers;

use common\models\User;
use Yii;
use backend\controllers\BaseController;
use yii\helpers\ColorHelper;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    //登录页面
    public function actionIndex()
    {
        $this->layout = 'page';
        if(self::_request()->isPost){
            $post = self::_post('User');
            ColorHelper::dump($post);
            die;
        }
        $model = new User();
        return $this->render('index',[
            'model'=>$model
        ]);
    }
    //注册页面
    public function actionRegister()
    {
        $this->layout = 'page';
        $model = new User();
        if($this->_request()->isPost){
            $post = $this->_post();
            $this->success('esee');
        }
        return $this->render('register',[
            'model'=>$model
        ]);
    }
}
