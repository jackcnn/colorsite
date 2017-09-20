<?php

namespace backend\modules\restaurant\controllers;

use backend\controllers\BaseController;

class IndexController extends BaseController
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}
