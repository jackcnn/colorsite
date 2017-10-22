<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Dishorder */

$this->title = 'Create Dishorder';
$this->params['breadcrumbs'][] = ['label' => 'Dishorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishorder-create">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
