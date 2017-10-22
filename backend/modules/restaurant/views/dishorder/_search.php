<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\DishorderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dishorder-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ownerid') ?>

    <?= $form->field($model, 'store_id') ?>

    <?= $form->field($model, 'ordersn') ?>

    <?= $form->field($model, 'sn') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'paytime') ?>

    <?php // echo $form->field($model, 'list') ?>

    <?php // echo $form->field($model, 'payinfo') ?>

    <?php // echo $form->field($model, 'openid') ?>

    <?php // echo $form->field($model, 'openid_list') ?>

    <?php // echo $form->field($model, 'payopenid') ?>

    <?php // echo $form->field($model, 'paytype') ?>

    <?php // echo $form->field($model, 'table_num') ?>

    <?php // echo $form->field($model, 'transaction_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
