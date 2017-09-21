<?php
namespace frontend\controllers;

use Yii;
use frontend\controllers\BaseController;
class SiteController extends BaseController
{
    public function actionIndex()
    {

        //https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN


        return $this->render('index');
    }
}
