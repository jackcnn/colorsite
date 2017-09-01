<?php

namespace backend\modules\user\controllers;

use yii\web\Controller;
use yii\helpers\ColorHelper;
class DefaultController extends Controller
{
    public $enableCsrfValidation = false ;
    public function actionIndex()
    {
        $request = ColorHelper::request();
        if($request->isPost){
            ColorHelper::dump($request->post());die;
        }
        return $this->renderPartial('index');
    }

    public function actionTest()
    {
        return $this->renderPartial('test');
    }
}
