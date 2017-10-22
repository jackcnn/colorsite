<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Dishorder */

$this->title = '查看订单: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '订单管理', 'url' => ['dishorder/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishorder-update">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
