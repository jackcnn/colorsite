<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('新建用户', ['create'], ['class' => 'layui-btn']) ?>
        <?= Html::a('点击','javascript:;', ['id'=>'getKeys','class' => 'layui-btn']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=>['class' => 'layui-table'],
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            'id',
            'parent_id',
            'token',
            [
                'attribute'=>'is_admin',
                'filter'=>['0'=>'no','1'=>'yes']
            ],
            'username',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?php
$js=<<<JS
layui.use('layer',function(){
    var layer = layui.layer;
    jQuery("#getKeys").click(function(){
        var keys = $('#w0').yiiGridView('getSelectedRows');
        //console.log(keys);
        layer.msg(String(keys))
    })
})
JS;
$this->registerJs($js);

?>