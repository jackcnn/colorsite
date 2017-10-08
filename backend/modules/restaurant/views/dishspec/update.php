<?php

use yii\helpers\Html;


$this->title = '修改菜品规格'. $model->name;
$this->params['breadcrumbs'][] = ['label' => '点餐系统', 'url' => ['/restaurant/index']];
$this->params['breadcrumbs'][] = ['label' => '菜品规格', 'url' => ['/restaurant/dishspec/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishspec-update">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
