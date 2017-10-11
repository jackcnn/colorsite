<?php

use yii\helpers\Html;
use yii\grid\GridView;
$this->title = '菜品分类';

$this->params['breadcrumbs'][] = ['label'=>'菜品管理','url'=>['/restaurant/dishes/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['tabs']['list']=backend\models\ShareData::tabslist('restaurant');
?>
<div class="category-index">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('新增分类', ['/restaurant/category/create'],['class' => 'layui-btn']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            'name',
            [
                'attribute'=>'logo',
                'value'=>function($model){
                    return "<img style='max-height: 100px;' src='$model->logo'/>";
                },
                'format'=>'raw'
            ],
            [
                'attribute'=>'slogo',
                'value'=>function($model){
                    return "<img style='max-height: 100px;' src='$model->slogo'/>";
                },
                'format'=>'raw'
            ],
            'sort',
            [
               'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{delete}'
            ],
        ],
    ]); ?>
</div>
