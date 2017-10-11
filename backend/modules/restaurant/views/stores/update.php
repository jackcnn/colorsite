<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Stores */

$this->title = '修改门店: ' . $model->name;
$this->params['breadcrumbs'][] = ['label'=>'门店列表','url'=>['/restaurant/stores/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stores-update">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
