<?php

use yii\helpers\Html;
use backend\widgets\LayForm;
?>

<div class="dishtable-form">

    <?php $form = LayForm::begin(); ?>

    <?= $form->field($model, 'ownerid')->lyhidden() ?>

    <?= $form->field($model, 'title')->lytextInput() ?>

    <?= $form->field($model, 'store_id')->lyhidden() ?>

    <?= $form->field($model, 'path')->lyhidden() ?>

    <?= $form->field($model, '')->lybuttons() ?>

    <?php LayForm::end(); ?>

</div>
