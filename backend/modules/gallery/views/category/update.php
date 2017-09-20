<?php

use yii\helpers\Html;

$this->title = '更新图集分类: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '图集打赏', 'url' => ['/gallery/index']];
$this->params['breadcrumbs'][] = ['label' => '图集分类', 'url' => ['/gallery-cate/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-cate-update">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
