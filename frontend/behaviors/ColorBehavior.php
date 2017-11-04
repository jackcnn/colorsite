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
    private $token;

    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    public function beforeAction($event)
    {
        $token = \Yii::$app->request->get("token");
        if($token){
            $this->ownerid = ColorHelper::token2id($token);
            $this->token = $token;
            \Yii::$app->view->params['token'] = $token;
        }else{
            $this->ownerid = 0;
            $this->token = 'chenglan';
            \Yii::$app->view->params['token'] = $this->token;
        }
        return true;
    }


    public function getOwnerid()
    {
        return $this->ownerid;
    }
    public function getToken()
    {
        return $this->token;
    }
}
