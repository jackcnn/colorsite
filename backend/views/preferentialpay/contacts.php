<?php
/**
 * Date: 2017/9/13 0013
 * Time: 18:17
 */
use backend\widgets\LayTabs;
$this->params['breadcrumbs'][] = ['label'=>'优惠买单','url'=>['/preferentialpay/index']];
$this->params['breadcrumbs'][] = '订单通知';
?>

<?= LayTabs::widget(['list'=>[
    ['订单处理',['/preferentialpay/index']],
    ['优惠设置',['/preferentialpay/setting']],
    ['订单通知',['/preferentialpay/contacts']]
]])?>
