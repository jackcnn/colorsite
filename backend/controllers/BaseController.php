<?php
/**
 * Date: 2017/8/30 0030
 * Time: 16:31
 */
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
class BaseController extends Controller
{
    public function behaviors()
    {
        //github-token:1842a92e1eed7f5487d491cc44a2fe0b64f0e381
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'except' => ['login', 'register','active','logout','forget-pwd','repwd'],//其他控制器不要取这些名字
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],//@表示认证用户
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'color' => [
                'class' => \backend\behaviors\ColorBehavior::className(),//初始化了一些东西
            ],
        ];
    }
}