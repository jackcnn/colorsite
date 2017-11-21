<?php
/**
 * Date: 2017/9/13 0013
 * Time: 09:53
 */
use yii\helpers\Html;
use backend\widgets\LayForm;

$this->title = '支付宝支付配置';
$this->params['breadcrumbs'][] = ['label' => '支付配置', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <div class="user-form layform-block">

        <?php $form = LayForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

        <?= $form->field($model,'mch_number')->lytextInput(['label'=>'商户号'])?>

        <?= $form->field($model,'mch_key')->lytextInput(['label'=>'商户KEY值'])?>

        <?= $form->field($model,'isuse')->lyswitch(['label'=>'是否启用'])?>

        <?= $form->field($model,'cert_path')->lyfile('支付宝支付cert证书','',true)?>

        <?= $form->field($model,'key_path')->lyfile('支付宝支付key证书','',true)?>

        <?= $form->field($model,'')->lybuttons()?>

        <?php LayForm::end(); ?>

    </div>

</div>