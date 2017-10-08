<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\DishesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dishes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ownerid') ?>

    <?= $form->field($model, 'token') ?>

    <?= $form->field($model, 'cateid') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'stock') ?>

    <?php // echo $form->field($model, 'multi') ?>

    <?php // echo $form->field($model, 'spec') ?>

    <?php // echo $form->field($model, 'recommend') ?>

    <?php // echo $form->field($model, 'onsale') ?>

    <?php // echo $form->field($model, 'cover') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'unit') ?>

    <?php // echo $form->field($model, 'labes') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
