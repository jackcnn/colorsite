<?php
/**
 * Date: 2017/9/12 0012
 * Time: 18:22
 */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="user-index">
    <h1 class="layform-h1">用户列表</h1>
    <p>
        <a class="layui-btn" href="/admin/user/demo/create">新建用户</a>        <a id="getKeys" class="layui-btn" href="javascript:;">点击</a>    </p>
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

                <td>微信公众号及微信支付</td>
                <td>
                    <a class="layui-btn layui-btn-mini" href="<?= Url::to(['thirdcfg/weixin'])?>" title="编辑" aria-label="编辑" data-pjax="0"><i class="layui-icon"></i>编辑</a>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="summary">第<b>1-1</b>条，共<b>1</b>条数据.</div>
    </div></div>
