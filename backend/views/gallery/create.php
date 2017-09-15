<?php

use yii\helpers\Html;

$this->title = '新建图集';
$this->params['breadcrumbs'][] = ['label' => '图集列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-create">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
