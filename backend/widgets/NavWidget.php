<?php
/**
 * Date: 2017/9/4 0004
 * Time: 11:18
 */
namespace backend\widgets;

use yii\base\Widget;

class NavWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $list = \backend\models\ShareData::navlist();
        return $this->render('nav',[
            'list'=>$list,
        ]);
    }
}