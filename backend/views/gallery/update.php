<?php

use yii\helpers\Html;

$this->title = '更新图集: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '图集列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '更新图集';
?>
<div class="gallery-update">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list'=>$list
    ]) ?>

</div>
