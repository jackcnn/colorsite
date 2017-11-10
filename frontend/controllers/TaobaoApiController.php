<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/10 0010
 * Time: 19:11
 */
namespace frontend\controllers;

use Yii;
use frontend\controllers\BaseController;
use yii\helpers\ColorHelper;
use yii\helpers\CurlHelper;
use yii\helpers\Url;

class TaobaoApiController extends BaseController
{

    public $enableCsrfValidation = false;

    public function actionIndex()
    {

        $res = \common\vendor\taobaoke\TaobaokeApiHelper::getlist();

        ColorHelper::dump($res);




        echo 1232;

    }
}