<?php
use backend\widgets\LayForm;
use \yii\helpers\Html;
$this->title = 'COLORSITE';
?>
<div class="layui-container" style="width: 45%;">

    <h1 class="layform-h1" style="text-align: left;padding: 80px 0px;"><span style="color:#20a0ff;font-weight: 500;">COLORSITE</span>管理系统</h1>
    <div class="user-form layform-block">

        <?php $form = LayForm::begin(); ?>

        <?= $form->field($model,'username')->lytextInput(['label'=>'邮　箱','placeholder'=>'请填写注册的邮箱','lay-verify'=>'email'])?>

        <?= $form->field($model, 'password')->lypasswordInput(['label'=>'密　码','placeholder'=>'请填写密码','max-length'=>'5']) ?>

        <?= $form->field($model,'token')->lycheckboxList(['1'=>'一段时间内自动登录'],['label'=>'记住我'])?>

        <?= $form->field($model,'')->lylink('忘记密码',['/site/register'])?>

        <?= $form->field($model,'')->lybuttons(['login'])?>

        <?php LayForm::end(); ?>

    </div>
</div>
<?php

$msg = \Yii::$app->session->getFlash('RegisterMsg');
if($msg){
$js =<<<JS
layui.use('layer', function(){
  var layer = layui.layer;
  layer.msg('$msg');
  
});  
JS;
    $this->registerJS($js);
}
?>