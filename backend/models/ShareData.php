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
            ['label'=>'图集','list'=>[
                ['label'=>'分类管理','router'=>['/gallery/category']],
                ['label'=>'第三方管理','router'=>['/thirdcfg/index']],
                ['label'=>'usepay','router'=>['/user/index/pay']]
            ]],
            ['label'=>'用户资料','router'=>['/user/index/index']]
        ];
        return $list;
    }
}