<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/25 0025
 * Time: 18:47
 */
namespace frontend\modules\dish\controllers;

use Yii;
use frontend\controllers\BaseController;
use yii\helpers\ColorHelper;

class TemplateController extends BaseController
{

    public function actionIndex()
    {
        ColorHelper::dump(\Yii::$app->request->get());
        ColorHelper::dump(\Yii::$app->request->post());
        echo 12312;

    }

}