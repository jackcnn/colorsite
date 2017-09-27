<?php
/**
 * Date: 2017/9/27 0027
 * Time: 16:54
 */
namespace frontend\widgets;

use common\weixin\JssdkHelper;
use yii\base\Widget;
use yii\helpers\ColorHelper;

class Jweixin extends Widget
{
    public $token;
    public $url;
    public function init()
    {
        parent::init();
    }
    public function run()
    {
        $owid = ColorHelper::token2id($this->token);
        $data = JssdkHelper::getSignPackage($owid);

        return $this->render('jweixin',[
            'data'=>$data
        ]);
    }
}