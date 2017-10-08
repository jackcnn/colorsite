<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Dishes */

$this->title = '新增菜品';
$this->params['breadcrumbs'][] = ['label' => '点餐系统', 'url' => ['/restaurant/index']];
$this->params['breadcrumbs'][] = ['label' => '菜品列表', 'url' => ['/restaurant/dishes/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishes-create">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'category'=>$category,
        'spec'=>$spec
    ]) ?>

</div>
