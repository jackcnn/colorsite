<?php
namespace frontend\controllers;

use Yii;
use frontend\controllers\BaseController;
use yii\data\Pagination;
use yii\helpers\ColorHelper;
use yii\helpers\CurlHelper;
use yii\helpers\Url;

class IndexController extends BaseController
{

    public $enableCsrfValidation = false;
    public $layout = "index";

    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionYilianyun()
    {
        echo '{"data":"OK"}';
    }






}