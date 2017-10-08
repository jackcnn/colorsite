<?php

use yii\helpers\Html;

$this->title = '新建菜品分类';
$this->params['breadcrumbs'][] = ['label' => '点餐系统', 'url' => ['/restaurant/index']];
$this->params['breadcrumbs'][] = ['label' => '菜品分类', 'url' => ['/restaurant/category/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="gallery-cate-create">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
