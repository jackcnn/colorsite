<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Dishreceive */


$this->title = '更新收款通知者('.$storeName.'): ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '门店管理', 'url' => ['/restaurant/stores/index']];
$this->params['breadcrumbs'][] = ['label' => '收款通知管理', 'url' => ['/restaurant/dishreceive/index','store_id'=>$model->store_id]];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="dishreceive-update">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
