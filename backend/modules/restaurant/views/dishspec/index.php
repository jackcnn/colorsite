<?php

use yii\helpers\Html;
use yii\grid\GridView;
$this->title = '菜品规格';

$this->params['breadcrumbs'][] = ['label'=>'菜品管理','url'=>['/restaurant/dishes/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['tabs']['list']=backend\models\ShareData::tabslist('restaurant');
?>
<div class="dishspec-index">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('新增规格', ['/restaurant/dishspec/create'],['class' => 'layui-btn']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'name',
                'label'=>'名称',
            ],
            [
                'attribute'=>'content',
                'label'=>'规格',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{delete}'
            ],
        ],
    ]); ?>
</div>
