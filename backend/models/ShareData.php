<?php
/**
 * 一些共享的数据
 * Date: 2017/9/13 0013
 * Time: 17:21
 */
namespace backend\models;
class ShareData
{
    /*
     * 后台菜单配置，所有的都在这里配置
     * */
    public static function navlist()
    {
        $list = [
            ['label'=>'点餐系统','list'=>[
                ['label'=>'订单管理','router'=>['/restaurant/order/index']],
                ['label'=>'菜品管理','router'=>['/restaurant/dishes/index']],
                ['label'=>'店铺管理','router'=>['/restaurant/stores']],
            ]],
            ['label'=>'功能','list'=>[
                ['label'=>'图集打赏','router'=>['/gallery/index/index']],
                ['label'=>'大转盘','router'=>['/user/index/pay']]
            ]],
            ['label'=>'用户资料','router'=>['/user/index/index']]
        ];
        return $list;
    }
    /*
     * tabs 菜单
     * */
    public static function tabslist($key)
    {
        $data['gallery']=[
            ['图集列表',['/gallery/index/index']],
            ['图集分类',['/gallery/category/index']],
            ['打赏记录',['/gallery/orders/index']]
        ];

        $data['restaurant']=[
            //['订单列表',['/restaurant/index/index']],
            ['菜品列表',['/restaurant/dishes/index']],
            ['菜品分类',['/restaurant/category/index']],
            ['规格管理',['/restaurant/dishspec/index']],
        ];



        return $data[$key];
    }
}