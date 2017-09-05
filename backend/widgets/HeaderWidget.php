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
        //在这里配置菜单,最多两层
        $list = [
            ['label'=>'商城','list'=>[
                ['label'=>'分类管理','router'=>'goods/category'],
                ['label'=>'商品管理','router'=>'goods/list'],
                ['label'=>'订单管理','router'=>'goods/orders']
            ]],
            ['label'=>'图集','list'=>[
                ['label'=>'分类管理','router'=>'gallery/category'],
                ['label'=>'图片管理','router'=>'gallery/list'],
                ['label'=>'打赏管理','router'=>'gallery/orders']
            ]],
            ['label'=>'配置','router'=>'config/index']
        ];
        return $this->render('header',[
            'list'=>$list,
        ]);
    }
}