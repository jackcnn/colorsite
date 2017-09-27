<?php

namespace backend\modules\joke\controllers;

use backend\controllers\BaseController;

class IndexController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
