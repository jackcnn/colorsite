<?php

use yii\helpers\Html;
use backend\widgets\LayForm;
?>

<div class="gallery-form layform-block">

    <?php $form = LayForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->lytextInput() ?>

    <?= $form->field($model, 'time')->widget(\backend\widgets\Laydate::className(),['label'=>'更新日期']) ?>

    <?= $form->field($model, 'source')->lytextInput(['label'=>'来源']) ?>

    <?= $form->field($model, 'author')->lytextInput(['label'=>'作者']) ?>

    <?= $form->field($model, 'cateid')->lyselectList($list,['label'=>'分类']) ?>

    <?= $form->field($model, 'sort')->lytextInput() ?>

    <?= $form->field($model, 'logo')->lyfile() ?>

    <?= $form->field($model, 'content')->lytextArea() ?>

    <?= $form->field($model, 'isopen')->lyswitch() ?>

    <?= $form->field($model, 'id')->lyhidden() ?>

    <?= $form->field($model, 'ownerid')->lyhidden() ?>

    <?= $form->field($model, 'token')->lyhidden() ?>

    <?= $form->field($model, 'created_at')->lyhidden() ?>

    <?= $form->field($model, 'updated_at')->lyhidden() ?>

    <?= $form->field($model, '')->lybuttons() ?>

    <?php LayForm::end(); ?>

</div>
