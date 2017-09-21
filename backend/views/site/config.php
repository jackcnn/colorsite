<?php

use yii\helpers\Html;
use backend\widgets\LayForm;
$this->title = '网站配置';
$this->params['breadcrumbs'][] = $this->title;
//
?>
<h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>
<div class="site-form layform-block">

    <?php $form = LayForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->lytextInput(['label'=>'网站名称'])?>

    <?= $form->field($model,'logo')->lyfile('网站LOGO','')?>

    <?= $form->field($model,'keywords')->lytextArea(['label'=>'网站关键词'])?>

    <?= $form->field($model,'description')->lytextArea(['label'=>'网站描述'])?>

    <?= $form->field($model,'')->lybuttons()?>

    <?php LayForm::end(); ?>

</div>
