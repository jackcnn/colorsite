<?php
/**
 * Date: 2017/9/12 0012
 * Time: 18:15
 * 第三方配置，如微信，支付宝等
 */
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use yii\db\Exception;
use yii\helpers\ColorHelper;
use yii\helpers\FileHelper;

class ThirdcfgController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }


}