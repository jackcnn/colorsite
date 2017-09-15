<?php

use yii\helpers\Html;
use backend\widgets\LayForm;
?>

<div class="gallery-form">

    <?php $form = LayForm::begin(); ?>

    <?= $form->field($model, 'title')->lytextInput() ?>

    <?= $form->field($model, 'time')->widget(\backend\widgets\Laydate::className()) ?>

    <?= $form->field($model, 'source')->lytextInput() ?>

    <?= $form->field($model, 'author')->lytextInput() ?>

    <?= $form->field($model, 'cateid')->lytextInput() ?>

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
