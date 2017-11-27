<?php

use yii\helpers\Html;
use backend\widgets\LayForm;

?>

<div class="dishreceive-form layform-block">

    <?php $form = LayForm::begin(); ?>

    <?= $form->field($model, 'name')->lytextInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->lytextInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_receive')->lyswitch(['0'=>'否','1'=>'是']) ?>

    <?= $form->field($model, 'wxname')->lytextInput(['disabled' => true]) ?>

    <?= $form->field($model, 'wxpic')->lyhidden() ?>

    <?= $form->field($model, 'openid')->lyhidden() ?>

    <?= $form->field($model, 'ownerid')->lyhidden() ?>

    <?= $form->field($model, 'created_at')->lyhidden() ?>

    <?= $form->field($model, 'updated_at')->lyhidden() ?>

    <?= $form->field($model, '')->lybuttons() ?>

    <?php LayForm::end(); ?>

</div>
