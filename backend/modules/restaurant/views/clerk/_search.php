<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\ClerkSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clerk-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ownerid') ?>

    <?= $form->field($model, 'token') ?>

    <?= $form->field($model, 'store_id') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'rights') ?>

    <?php // echo $form->field($model, 'openid') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
