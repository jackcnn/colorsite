<?php
/**
 * Date: 2017/9/14 0014
 * Time: 15:18
 */

namespace frontend\behaviors;

use Yii;
use yii\base\ActionEvent;
use yii\base\Behavior;
use yii\helpers\ColorHelper;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
class ColorBehavior extends Behavior
{

    private $ownerid;

    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    public function beforeAction($event)
    {
        $token = \Yii::$app->request->get("token");
        $this->ownerid = ColorHelper::token2id($token);
        \Yii::$app->view->params['token'] = $token;
        return true;
    }


    public function getOwnerid()
    {
        return $this->ownerid;
    }
}
