<?php
/**
 * Date: 2017/9/12 0012
 * Time: 18:22
 */
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '支付配置';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <h1 class="layform-h1"><?=$this->title?></h1>
    <div id="w0" class="grid-view">
        <table class="layui-table">
            <thead>
            <tr>
                <th>
                    类型
                </th>
                <th class="action-column">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>微信支付</td>
                <td>
                    <a class="layui-btn layui-btn-mini" href="<?= Url::to(['payconfig/weixin'])?>" title="编辑" aria-label="编辑" data-pjax="0"><i class="layui-icon"></i>编辑</a>
                </td>
            </tr>
<!--            <tr>-->
<!--                <td>支付宝支付</td>-->
<!--                <td>-->
<!--                    <a class="layui-btn layui-btn-mini" href="--><?//= Url::to(['payconfig/alipay'])?><!--" title="编辑" aria-label="编辑" data-pjax="0"><i class="layui-icon"></i>编辑</a>-->
<!--                </td>-->
<!--            </tr>-->
            </tbody>
        </table>
    </div></div>
