<?php

use yii\helpers\Html;
use backend\widgets\LayForm;

/* @var $this yii\web\View */
/* @var $model common\models\Printer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="printer-form  layform-block">

    <?php $form = LayForm::begin(); ?>

    <?= $form->field($model, 'store_id')->lyselectList($stores)?>

    <?= $form->field($model, 'title')->lytextInput() ?>

    <?= $form->field($model, 'machine_code')->lytextInput() ?>

    <?= $form->field($model, 'actions')->lycheckboxList(
            ['qrcode'=>'后台二维码打印','dishes'=>'菜单打印','payres'=>'付款后打印'],
            ['tips'=>'(后台二维码打印有店员绑定二维码打印，餐牌二维码打印等)'])
    ?>

    <?= $form->field($model, 'isuse')->lyswitch([],'是|否') ?>

    <?= $form->field($model, 'created_at')->lyhidden() ?>

    <?= $form->field($model, 'updated_at')->lyhidden() ?>


    <?= $form->field($model, 'ownerid')->lyhidden() ?>

    <?= $form->field($model, '')->lybuttons() ?>

    <?php LayForm::end(); ?>

</div>
