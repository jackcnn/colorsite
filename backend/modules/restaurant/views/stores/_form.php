<?php

use yii\helpers\Html;
use backend\widgets\LayForm;
?>

<div class="stores-form layform-block">

    <?php $form = LayForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>



    <?= $form->field($model, 'name')->lytextInput() ?>

    <?= $form->field($model, 'needpay')->lyradioList(['0'=>'店员合作点餐买单','1'=>'付款后直接打单'],['label'=>'模式选择']) ?>

    <?= $form->field($model, 'desc')->lytextArea() ?>

    <?= $form->field($model, 'logo')->lyFile() ?>

    <?= $form->field($model, 'address')->lytextArea(['tips'=>'<a target="_blank" href="http://lbs.qq.com/tool/getpoint/">点击获取经纬度坐标</a>']) ?>

    <?= $form->field($model, 'lng')->lytextInput() ?>

    <?= $form->field($model, 'lat')->lytextInput() ?>

    <?= $form->field($model, 'phone')->lytextInput() ?>

    <?= $form->field($model, 'created_at')->lytextInput(['label'=>'创建时间','disabled'=>true,'value'=>\Yii::$app->formatter->asDatetime($model->created_at)]) ?>

    <?= $form->field($model, 'updated_at')->lyhidden() ?>

    <?= $form->field($model, 'ownerid')->lyhidden() ?>

    <?= $form->field($model, 'token')->lyhidden() ?>


    <?= $form->field($model, '')->lybuttons() ?>

    <?php LayForm::end(); ?>

</div>
