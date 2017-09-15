<?php
/**
 * Date: 2017/9/14 0014
 * Time: 15:18
 */

namespace backend\behaviors;

use Yii;
use yii\base\ActionEvent;
use yii\base\Behavior;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
class ColorBehavior extends Behavior
{
    public $actions = [];

    private $identity;
    private $token;
    private $ownerid;


    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }
    public function beforeAction($event)
    {
        $action = $event->action->id;
        if(\Yii::$app->user->isGuest){
            return false;
        }else{
            $this->identity = \Yii::$app->user->identity;
            $this->token = $this->identity->token;
            if($this->identity->parent_id<1){//一级用户，userid
                $this->ownerid = $this->identity->id;
            }else{//二级用户，父级的userid
                $this->ownerid = $this->identity->parent_id;
            }
        }
        return true;
    }

    public function getIdentity()
    {
        return $this->identity;
    }
    public function getToken()
    {
        return $this->token;
    }
    public function getOwnerid()
    {
        return $this->ownerid;
    }

}
