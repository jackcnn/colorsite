<?php
use backend\widgets\LayForm;
use \yii\helpers\Html;
$this->title = 'COLORSITE';
?>
<div class="layui-container" style="width: 45%;">

    <h1 class="layform-h1" style="text-align: left;padding: 80px 0px;">感谢注册<span style="color:#20a0ff;font-weight: 500;">COLORSITE</span>管理系统</h1>

    <div class="user-form layform-block">

        <?php $form = LayForm::begin(); ?>

        <?= $form->field($model,'nickname')->lytextInput(['label'=>'昵　　称','placeholder'=>'请填写昵称'])?>

        <?= $form->field($model,'username')->lytextInput(['label'=>'邮　　箱','placeholder'=>'用于登录和帐号激活'])?>

        <?= $form->field($model, 'password')->lypasswordInput(['label'=>'密　　码','placeholder'=>'请填写密码']) ?>

        <?= $form->field($model, 'password')->lypasswordInput(['label'=>'确认密码','placeholder'=>'请再次填写密码']) ?>

        <?= $form->field($model,'')->lylink('已有帐号，去登录',['/site/index'])?>

        <?= $form->field($model,'')->lybuttons(['submit','reset'])?>

        <?php LayForm::end(); ?>

    </div>
</div>