<?php
/**
 * Date: 2017/9/7 0007
 * Time: 16:07
 */
namespace backend\widgets;

use yii\base\Widget;

class FooterWidget extends Widget
{
    public $data="©  广州市橙蓝网络科技有限公司";

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return '<div class="layui-footer">'.$this->data.'</div>';
    }
}