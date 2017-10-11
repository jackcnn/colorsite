<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Clerk */

$this->title = '更新店员('.$storeName.'): ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '门店管理', 'url' => ['/restaurant/stores/index']];
$this->params['breadcrumbs'][] = ['label' => '店员管理', 'url' => ['/restaurant/clerk/index','store_id'=>$model->store_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clerk-update">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
