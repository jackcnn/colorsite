<?php
/**
 * Date: 2017/9/11 0011
 * Time: 11:30
 */
use yii\helpers\Html;
use backend\widgets\LayForm;
$this->title = '帐号基本信息';
//$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <div class="user-form layform-block">

        <?php $form = LayForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

        <?= $form->field($model,'username')->lytextInput(['label'=>'登录邮箱','disabled'=>true])?>

        <?= $form->field($model,'nickname')->lytextInput()?>

        <?= $form->field($model,'is_admin')->lyradioList(['0'=>'不是','1'=>'是'])?>

        <?= $form->field($model,'is_admin')->lycheckboxList(['0'=>'不是','1'=>'是'],['label'=>'馆馆员'])?>

        <?= $form->field($model,'is_admin')->lyswitch('是|否',['label'=>'馆馆员11'])?>

        <?= $form->field($model,'avatar')->lyfile('文件上传','(600px*600px)')?>

        <?= $form->field($model,'expire')->lytextInput(['label'=>'过期时间','disabled'=>true,'value'=>date('Y-m-d H:i:s',$model->expire)])?>

        <?= $form->field($model,'created_at')->lytextInput(['label'=>'注册时间','disabled'=>true,'value'=>date('Y-m-d H:i:s',$model->created_at)])?>

        <?= $form->field($model,'')->lybuttons()?>

        <?php LayForm::end(); ?>

    </div>

</div>
