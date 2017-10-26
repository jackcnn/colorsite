<?php

namespace backend\modules\taobao\controllers;

use backend\controllers\BaseController;


class DefaultController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
