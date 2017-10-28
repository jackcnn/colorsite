<?php

use yii\helpers\Html;
use yii\grid\GridView;


$this->title = '门店列表';
//$this->params['breadcrumbs'][] = ['label'=>'门店管理','url'=>['/restaurant/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="printer-index">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增打印机', ['create'], ['class' => 'layui-btn']) ?>

        <?= Html::a('打印排号页面', ['code'], ['class' => 'layui-btn colorsite-iframe-show']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'title',
                'filter'=>false
            ],
            [
                'attribute'=>'machine_code',
                'filter'=>false
            ],
            [
                'attribute'=>'actions',
                'value'=>function($model){
                    $data = json_decode($model->actions,1);
                    $html = '';
                    if(in_array('qrcode',$data)){
                        $html.='排号打印';
                    }
                    if(in_array('dishes',$data)){
                        $html.=',菜单打印';
                    }
                    return $html;
                },
                'filter'=>false
            ],
            [
                'attribute'=>'store_id',
                'label'=>'所属门店',
                'value'=>'store.name',
                'filter'=>$stores
            ],
            [
                'attribute'=>'',
                'label'=>'额外操作',
                'value'=>function($model){
                    return Html::a('打印机器信息', 'javascript:;', ['data-link'=>\yii\helpers\Url::to(['printer','id'=>$model->id]),'class' => 'printer-msg layui-btn layui-btn-mini']);
                },
                'format'=>'Raw'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?php
$js = <<<JS

layui.use('layer', function(){
    var layer = layui.layer;
    //按钮弹出的confirmed
    jQuery(".printer-msg").click(function (e) {
        e.preventDefault();
        var href = jQuery(this).data("link");
        layer.confirm('确认打印小票机的信息？', {icon: 3, title:'提示'}, function(index){
            location.href = href ;
            return;
        });
    })
});

JS;

$this->registerJS($js);
?>