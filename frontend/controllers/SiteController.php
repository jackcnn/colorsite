<?php
namespace frontend\controllers;

use Yii;
use frontend\controllers\BaseController;
class SiteController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
