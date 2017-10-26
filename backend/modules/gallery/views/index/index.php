<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = '图集打赏';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = '图集列表';
$this->params['tabs']['list']=backend\models\ShareData::tabslist('gallery');
?>
<div class="gallery-index">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新建图集', ['create'], ['class' => 'layui-btn']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
             [
                 'attribute'=>'logo',
                 'filter'=>false,
                 'format'=>'raw',
                 'value'=>function($model){
                    return "<img src='".$model->logo."'/>";
                 }
             ],
             'source',
             'author',
             [
                 'attribute'=>'cateid',
                 'value'=>'category.name',
                 'filter'=>$catelist
             ],
            [
                'attribute'=>'',
                'value'=>function($model){
                    return Html::a("上新图",['/gallery/index/taobao','id'=>$model->id],['class'=>'layui-btn layui-btn-mini','target'=>'_blank']);
                },
                'format'=>'Raw'
            ],
            ['class' => 'yii\grid\ActionColumn','template'=>'{update}{gallery}{delete}'],
        ],
    ]); ?>
</div>
