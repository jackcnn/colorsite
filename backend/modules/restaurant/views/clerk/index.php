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
                    if(is_array($arr) && count($arr)){
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
            [
                'attribute'=>'wxname',
                'label'=>'绑定微信号'
            ],
            ['class' => 'yii\grid\ActionColumn'],
            [
                'attribute'=>'',
                'value'=>function($model){
                    $html = Html::a('小程序绑定', 'javascript:;', ['class' => 'layui-btn layui-btn-mini bind','data-href'=>\yii\helpers\Url::to(['/restaurant/clerk/bind','id'=>$model->id,'store_id'=>\Yii::$app->request->get("store_id")])]);

                    $html .= Html::a('收款信息绑定', 'javascript:;', ['class' => 'layui-btn layui-btn-mini bind-public','data-href'=>\yii\helpers\Url::to(['/restaurant/clerk/bind-public','id'=>$model->id,'store_id'=>\Yii::$app->request->get("store_id")])]);


                    $html .= Html::a('解除绑定', ['/restaurant/clerk/unbind','id'=>$model->id,'store_id'=>\Yii::$app->request->get("store_id")], ['class' => 'layui-btn layui-btn-mini layui-btn-danger unbind']);

                    return $html;

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
          title:'小程序绑定',
          type: 2, 
          shadeClose:true,
          area: ['500px', '500px'],
          content: link
        }); 
    })
    
    jQuery(".bind-public").click(function() {
        var link = jQuery(this).attr("data-href");
        layer.open({
          title:'收款信息绑定',
          type: 2, 
          shadeClose:true,
          area: ['500px', '500px'],
          content: link
        }); 
        
    })
    
    
    jQuery(".unbind").click(function (e) {
        e.preventDefault();
        var href = jQuery(this).attr('href');
        layer.confirm('你确定要解除绑定吗？', {icon: 3, title:'提示'}, function(index){
            return location.href=href;
        });
    })
    
})

JS;

$this->registerJS($js);



?>