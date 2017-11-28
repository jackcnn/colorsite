<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DishtableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '餐牌列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .layui-table img{
        max-width:500px;
    }
    .layui-table .img{
        width:100px;
    }
    .layui-table .img.scale{
        width:300px;
    }

</style>
<div class="dishtable-index">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增餐牌', ['create','storeid'=>$store->id], ['class' => 'layui-btn']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
             [
                 'attribute'=>'code',
                 'format'=>'raw',
                 'value'=>function($model){
                    return Html::img($model->code,['class'=>'img']);
                 }
             ],
            ['class' => 'yii\grid\ActionColumn'],
            [
                'attribute'=>'',
                'label'=>'更多操作',
                'value'=>function($model){

                    $html = Html::a('生成二维码图片', ['/restaurant/dishtable/createcode','id'=>$model->id], ['class' => 'layui-btn layui-btn-mini']);

                    $html .= Html::a('打印绑定二维码', ['/restaurant/dishtable/print-qrcode','id'=>$model->id,'store_id'=>\Yii::$app->request->get("storeid")], ['class' => 'layui-btn layui-btn-mini']);

                    return $html;
                },
                'format'=>'raw'
            ],
        ],
    ]); ?>
</div>
<?php
$js = <<<JS

    jQuery(".layui-table .img").click(function() {
        $(this).toggleClass("scale");
    })



JS;

$this->registerJs($js);

?>