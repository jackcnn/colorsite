<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ClerkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '店员列表('.$storeName.')';
$this->params['breadcrumbs'][] = ['label'=>'门店管理','url'=>['/restaurant/stores/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clerk-index">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增店员', ['create','store_id'=>\Yii::$app->request->get("store_id"),'storeName'=>urlencode($storeName)], ['class' => 'layui-btn']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
             'desc',
             'phone',
             [
                 'attribute'=>'rights',
                 'format'=>'raw',
                 'value'=>function($model){
                    $arr = json_decode($model->rights,1);
                    if(is_array($arr)){
                        $data = backend\models\ShareData::clerkrights();
                        $res = "";
                        foreach($arr as $key=>$value){
                            if($value != "0"){
                                $res = $res . '  <i class="layui-icon">&#xe627;</i>' .$data[$value];
                            }
                        }
                        return $res;

                    }
                 }
             ],
             'openid',
            ['class' => 'yii\grid\ActionColumn'],
            [
                'attribute'=>'',
                'value'=>function($model){
                    return Html::a('微信绑定', 'javascript:;', ['class' => 'layui-btn layui-btn-mini bind','data-href'=>\yii\helpers\Url::to(['/restaurant/clerk/bind','id'=>$model->id,'store_id'=>$model->id])]);
                },
                'format'=>'raw'
            ]
        ],
    ]); ?>
</div>

<?php
$js = <<<JS

layui.use('layer',function(){
    var layer=layui.layer;
    
    jQuery(".bind").click(function() {
        var link = jQuery(this).attr("data-href");
        layer.open({
          title:'微信绑定',
          type: 2, 
          shadeClose:true,
          area: ['500px', '500px'],
          content: link
        }); 
        
    })
    
})

JS;

$this->registerJS($js);



?>