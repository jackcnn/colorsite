<?php

use yii\helpers\Html;
use backend\widgets\LayuiForm;
?>

<div class="user-form">

    <?php $form = LayuiForm::begin(); ?>

    <?= $form->field($model, 'updated_at')->lytextInput(['label'=>'更新时间','tips'=>'选择更新时间','placeholder'=>'请填写','lay-verify'=>'email']) ?>

    <?= $form->field($model, 'password')->lypasswordInput(['label'=>'密码','placeholder'=>'请填写','max-length'=>'5']) ?>

    <?= $form->field($model,'is_admin')->lyradioList(['0'=>'否','1'=>'是'],'管理员')?>

    <?= $form->field($model,'expire')->lycheckboxList(['one'=>'模块1','two'=>'模块2','three'=>'模块3'],'模块')?>

    <?= $form->field($model,'is_active')->lyswitch('开启|关闭','激活')?>

    <?= $form->field($model,'nickname')->lyselectList(['0'=>'lurongze','1'=>'lrz','2'=>'kkk'])?>


    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-danger">重置</button>
        </div>
    </div>

    <?php LayuiForm::end(); ?>

</div>
