<?php

use yii\helpers\Html;
use backend\widgets\LayForm;

?>

<div class="dishspec-form layform-block">

    <?php $form = LayForm::begin(); ?>

    <?= $form->field($model, 'ownerid')->lyhidden() ?>

    <?= $form->field($model, 'token')->lyhidden() ?>

    <?= $form->field($model, 'name')->lytextInput(['label'=>'规格名称']) ?>

    <?= $form->field($model, 'content')->widget(backend\widgets\Labels::className(),
        ['label'=>'规格分类','defaults'=>['大份','中份','小份']]) ?>

    <?= $form->field($model, '')->lybuttons() ?>

    <?php LayForm::end(); ?>

</div>
