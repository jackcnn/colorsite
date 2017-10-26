<?php
/**
 * Created by PhpStorm.
 * User: lurongze
 * Date: 2017/10/26
 * Time: 9:31
 */

namespace frontend\controllers;


use Yii;
use frontend\controllers\BaseController;
use yii\data\Pagination;
use yii\helpers\ColorHelper;
use yii\helpers\CurlHelper;
use yii\helpers\Url;

class TaobaoController extends BaseController
{

    public $enableCsrfValidation = false;

    public function actionIndex()
    {

        return $this->renderPartial("index");
    }

    public function actionGetdata()
    {

        $data= (new \yii\db\Query())
            ->select(['title', 'desc'])
            ->from('{{%jokes}}')
            ->orderBy("rand()")
            ->limit(10)
            ->all();

        return $this->asJson($data);

    }





}