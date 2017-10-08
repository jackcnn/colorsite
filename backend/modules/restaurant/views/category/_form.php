<?php

use yii\helpers\Html;
use backend\widgets\LayForm;

?>

<div class="gallery-cate-form layform-block">

    <?php $form = LayForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'ownerid')->lyhidden() ?>

    <?= $form->field($model, 'token')->lyhidden() ?>
    <?= $form->field($model, 'id')->lyhidden() ?>

    <?= $form->field($model, 'name')->lytextInput() ?>

    <?= $form->field($model, 'logo')->lyfile() ?>

    <?= $form->field($model, 'slogo')->lyfile() ?>

    <?= $form->field($model, 'desc')->lytextArea(['rows' => 6]) ?>

    <?= $form->field($model, 'sort')->lytextInput() ?>

    <?= $form->field($model, '')->lybuttons() ?>

    <?php LayForm::end(); ?>

</div>
