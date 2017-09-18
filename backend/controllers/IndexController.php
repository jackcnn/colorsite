<?php
/**
 * Date: 2017/9/18 0018
 * Time: 15:46
 */
namespace backend\controllers;

use Yii;
use yii\web\Controller;
class IndexController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }


}
