<?php

use yii\helpers\Html;
use backend\widgets\LayForm;

?>

<div class="dishorder-form layform-block">

    <?php $form = LayForm::begin(); ?>


    <?= $form->field($model, 'ordersn')->lytextInput(['disabled' => true]) ?>

    <?= $form->field($model, 'status')->lyselectList(['0'=>'下单','1'=>'等待付款','2'=>'已付款'],['label'=>'订单状态','disabled'=>true]) ?>

    <?= $form->field($model, 'amount')->lytextInput(['disabled' => true,'label'=>'订单金额']) ?>

    <?= $form->field($model, 'paytime')->lytextInput(['disabled' => true,'label'=>'付款时间']) ?>

    <?= $form->field($model, 'openid')->lytextInput(['disabled' => true,'label'=>'下单店员']) ?>

    <?= $form->field($model, 'payopenid')->lytextInput(['disabled' => true,'label'=>'付款人']) ?>

    <?= $form->field($model, 'paytype')->lytextInput(['disabled' => true,'label'=>'支付方式']) ?>

    <?= $form->field($model, 'table_num')->lytextInput(['disabled' => true]) ?>

    <?= $form->field($model, 'ownerid')->lyhidden() ?>

    <?= $form->field($model, 'store_id')->lyhidden() ?>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <a href="javascript:history.back();" class="layui-btn layui-btn-warm">返回</a></div>
    </div>

    <?php LayForm::end(); ?>

</div>
