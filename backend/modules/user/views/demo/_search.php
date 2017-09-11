<?php

use yii\helpers\Html;
use backend\widgets\LayuiForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search layform-block">

    <?php $form = LayuiForm::begin([
            'action'=>['index'],
            'method'=>'get'
    ]); ?>

    <?= $form->field($model,'created_at')->widget(backend\widgets\Laydate::className(),['label'=>'日期'])?>

    <?= $form->field($model,'')->lybuttons()?>

    <?php LayuiForm::end(); ?>

</div>
