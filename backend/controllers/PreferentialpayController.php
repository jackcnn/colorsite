<?php
/**
 * Date: 2017/9/13 0013
 * Time: 18:12
 * 优惠买单
 */
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use yii\db\Exception;
use yii\helpers\ColorHelper;
use yii\helpers\FileHelper;

class PreferentialpayController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionSetting()
    {
        return $this->render('setting');
    }
    public function actionContacts()
    {
        return $this->render('contacts');
    }




}