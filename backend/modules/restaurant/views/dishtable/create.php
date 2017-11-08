<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Dishtable */

$this->title = '新增餐牌';
$this->params['breadcrumbs'][] = ['label' => '点餐系统', 'url' => ['/restaurant/index']];
$this->params['breadcrumbs'][] = ['label' => '门店列表', 'url' => ['/restaurant/stores/index']];
$this->params['breadcrumbs'][] = ['label' => '餐牌列表列表', 'url' => ['/restaurant/dishtable/index','storeid'=>\Yii::$app->request->get("storeid")]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishtable-create">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
