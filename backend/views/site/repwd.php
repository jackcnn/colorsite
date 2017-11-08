<?php
use backend\widgets\LayForm;
use \yii\helpers\Html;
$this->title = 'COLORSITE';
?>
<div class="layui-container" style="width: 45%;">

    <h1 class="layform-h1" style="text-align: left;padding: 80px 0px;"><span style="color:#20a0ff;font-weight: 500;">COLORSITE</span>管理系统</h1>
    <div class="user-form layform-block">

        <?php $form = LayForm::begin(); ?>

        <?= $form->field($model,'username')->lytextInput(['label'=>'邮　箱','readonly'=>true])?>

        <?= $form->field($model,'password')->lytextInput(['label'=>'新密码'])?>

        <?= $form->field($model,'token')->lytextInput(['label'=>'确认密码'])?>

        <?= $form->field($model,'')->lylink('输入新密码',"javascript:;")?>

        <?= $form->field($model,'')->lybuttons()?>

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