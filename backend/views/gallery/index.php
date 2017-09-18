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
             'source',
             'author',
             [
                 'attribute'=>'cateid',
                 'value'=>'category.name',
                 'filter'=>['0'=>'no','1'=>'yes']
             ],
             'logo',
            ['class' => 'yii\grid\ActionColumn','template'=>'{update}{gallery}{delete}'],
        ],
    ]); ?>
</div>
