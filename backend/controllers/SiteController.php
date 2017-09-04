<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
