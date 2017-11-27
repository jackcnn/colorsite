<?php

use yii\helpers\Html;
use backend\widgets\LayForm;
?>

<div class="clerk-form layform-block">

    <?php $form = LayForm::begin(); ?>

    <?= $form->field($model, 'name')->lytextInput() ?>

    <?= $form->field($model, 'phone')->lytextInput() ?>

    <?= $form->field($model, 'rights')->lycheckboxList(backend\models\ShareData::clerkrights()) ?>

    <?= $form->field($model, 'desc')->lytextArea() ?>

    <?= $form->field($model, 'openid')->lyhidden() ?>

    <?= $form->field($model, 'created_at')->lyhidden() ?>

    <?= $form->field($model, 'updated_at')->lyhidden() ?>

    <?= $form->field($model, 'ownerid')->lyhidden() ?>

    <?= $form->field($model, 'token')->lyhidden() ?>

    <?= $form->field($model, 'store_id')->lyhidden() ?>

    <?= $form->field($model, '')->lybuttons() ?>

    <?php LayForm::end(); ?>

</div>
