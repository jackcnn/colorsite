<?php
/**
 * Date: 2017/9/13 0013
 * Time: 09:53
 */
use yii\helpers\Html;
use backend\widgets\LayForm;

$this->title = '微信公众号及支付配置';
$this->params['breadcrumbs'][] = ['label' => '第三方配置', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <div class="user-form layform-block">

        <?php $form = LayForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

        <?= $form->field($model,'appid')->lytextInput(['label'=>'公众号appid'])?>

        <?= $form->field($model,'appsecret')->lytextInput(['label'=>'公众号appsecret'])?>

        <?= $form->field($model,'mch_number')->lytextInput(['label'=>'商户号'])?>

        <?= $form->field($model,'mch_key')->lytextInput(['label'=>'商户KEY值'])?>

        <?= $form->field($model,'api_token')->lytextInput(['label'=>'TOKEN值'])?>

        <?= $form->field($model,'aeskey')->lytextInput(['label'=>'AESKEY值'])?>

        <?= $form->field($model,'isuse')->lyswitch(['label'=>'是否启用'])?>

        <?= $form->field($model,'apiclient_cert')->lyfile('微信支付cert证书','',true)?>

        <?= $form->field($model,'apiclient_key')->lyfile('微信支付key证书','',true)?>

        <?= $form->field($model,'')->lybuttons()?>

        <?php LayForm::end(); ?>

    </div>

</div>