<?php

use yii\helpers\Html;
use yii\grid\GridView;
$this->title = '图集分类';

$this->params['breadcrumbs'][] = ['label'=>'图集打赏','url'=>['/gallery/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['tabs']['list']=backend\models\ShareData::tabslist('gallery');
?>
<div class="category-index">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('新增分类', ['/gallery-cate/create'],['class' => 'layui-btn']) ?>
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
