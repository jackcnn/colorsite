<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use yii\helpers\ColorHelper;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    public $enableCsrfValidation=false;
    public function actionIndex()
    {
        if($_POST){
            ColorHelper::dump($_POST);die;
        }
        return $this->render('index');
    }
}
