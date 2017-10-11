<?php

use yii\helpers\Html;

$storeName = urldecode(\Yii::$app->request->get("storeName"));

$this->title = '新增店员('.$storeName.')';
$this->params['breadcrumbs'][] = ['label' => '门店管理', 'url' => ['/restaurant/stores/index']];
$this->params['breadcrumbs'][] = ['label' => '店员管理', 'url' => ['/restaurant/clerk/index','store_id'=>\Yii::$app->request->get("store_id")]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clerk-create">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
