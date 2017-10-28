<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DishesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '菜品列表';
$this->params['breadcrumbs'][] = ['label'=>'菜品管理','url'=>['/restaurant/dishes/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['tabs']['list']=backend\models\ShareData::tabslist('restaurant');

?>
<div class="dishes-index">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增菜品', ['/restaurant/dishes/create'],['class' => 'layui-btn']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'name',
                'value'=>'name',
            ],
             [
                 'attribute'=>'cover',
                 'value'=>function($model){
                    return "<img src='".$model->cover."'/>";
                 },
                 'format'=>'raw',
                 'filter' =>false
             ],
             [
                 'attribute'=>'price',
                 'label'=>'价格',
                 'value'=>function($model){
                    return ($model->price/100)."元";
                 },
                 'filter' =>false
             ],

            [
                'attribute'=>'stock',
                'filter' =>false
            ],
            [
                'attribute'=>'recommend',
                'value'=>function($model){
                    return $model->recommend>0?"是":"否";
                },
                'filter' =>false
            ],
            [
                'attribute'=>'onsale',
                'value'=>function($model){
                    return $model->onsale>0?"是":"否";
                },
                'filter' =>false
            ],
            [
                'attribute'=>'cateid',
                'value'=>'category.name',
                'filter'=>$category
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
