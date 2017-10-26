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
                ['label'=>'订单管理','router'=>['/restaurant/dishorder/index']],
                ['label'=>'菜品管理','router'=>['/restaurant/dishes/index']],
                ['label'=>'门店管理','router'=>['/restaurant/stores/index']],
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

    //店员权限
    public static function clerkrights()
    {
        $data = [
            'ordering'=>'点餐',
            'setpay'=>'设置订单付款',
        ];

        return $data;
    }
}