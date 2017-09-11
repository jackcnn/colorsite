<?php

use yii\helpers\Html;
use backend\widgets\LayForm;
?>

<div class="user-form layform-block">

    <?php $form = LayForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model,'created_at')->widget(backend\widgets\Laydate::className(),['label'=>'日期'])?>

    <?= $form->field($model, 'updated_at')->lytextInput(['label'=>'更新时间','tips'=>'选择更新时间','placeholder'=>'请填写','lay-verify'=>'email']) ?>

    <?= $form->field($model, 'password')->lypasswordInput(['label'=>'密码','placeholder'=>'请填写','max-length'=>'5']) ?>

    <?= $form->field($model,'is_admin')->lyradioList(['0'=>'否','1'=>'是'],'管理员')?>

    <?= $form->field($model,'expire')->lycheckboxList(['one'=>'模块1','two'=>'模块2','three'=>'模块3'],'模块')?>

    <?= $form->field($model,'is_active')->lyswitch('开启|关闭','激活')?>

    <?= $form->field($model,'nickname')->lyselectList(['0'=>'lurongze','1'=>'lrz','2'=>'kkk'])?>

    <?= $form->field($model,'token')->lyfile('文件上传','(300px*450px)')?>

    <?= $form->field($model,'avatar')->lytextArea()?>

    <?= $form->field($model,'username')->widget(backend\widgets\KindeditorWidget::className())?>

    <?= $form->field($model,'')->lybuttons()?>

    <?php LayForm::end(); ?>

</div>

