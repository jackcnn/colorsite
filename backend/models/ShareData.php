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
            ['label'=>'商城模块','list'=>[
                ['label'=>'优惠买单','router'=>['/preferentialpay/index']],
                ['label'=>'商品管理','router'=>['/goods/list']],
                ['label'=>'订单管理','router'=>['/goods/orders']]
            ]],
            ['label'=>'功能','list'=>[
                ['label'=>'图集打赏','router'=>['/gallery/index']],
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
            ['图集列表',['/gallery/index']],
            ['图集分类',['/gallery-cate/index']],
            ['打赏记录',['/gallery/orders']]
        ];
        return $data[$key];
    }
}