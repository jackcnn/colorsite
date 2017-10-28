<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Printer */

$this->title = '编辑打印机: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '打印机列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="printer-update">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'stores'=>$stores
    ]) ?>

</div>
