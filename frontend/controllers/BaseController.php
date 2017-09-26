<?php
/**
 * Date: 2017/8/30 0030
 * Time: 16:31
 */
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'color' => [
                'class' => \frontend\behaviors\ColorBehavior::className(),//初始化了一些东西
            ],
        ];
    }


}