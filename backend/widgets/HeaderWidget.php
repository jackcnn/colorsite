<?php
/**
 * Date: 2017/9/5 0005
 * Time: 14:23
 */
namespace backend\widgets;

use yii\base\Widget;

class HeaderWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('header');
    }
}