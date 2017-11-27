<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DishreceiveSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '收款通知管理（'.$storeName.'）';
$this->params['breadcrumbs'][] = ['label'=>'门店管理','url'=>['/restaurant/stores/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishreceive-index">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增收款通知者', ['create','store_id'=>\Yii::$app->request->get("store_id"),'storeName'=>urlencode($storeName)], ['class' => 'layui-btn']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'phone',
            [
                'attribute'=>'wxname',
                'value'=>function($model){
                    return urldecode($model->wxname);
                }
            ],
            [
                'attribute'=>'wxpic',
                'value'=>function($model){
                    if($model->wxpic){
                        $html="<img src='".$model->wxpic."' style='width: 50px;'/>";
                    }else{
                        $html='';
                    }
                    return $html;
                },
                'format'=>'raw'
            ],
            [
                'attribute'=>'is_receive',
                'value'=>function($model){
                    $data = ['0'=>'不接收信息','1'=>'接收信息'];
                    return $data[$model->is_receive];
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
            [
                'attribute'=>'',
                'value'=>function($model){

                    $html = Html::a('公众号绑定', 'javascript:;', ['class' => 'layui-btn layui-btn-mini bind-public','data-href'=>\yii\helpers\Url::to(['/restaurant/dishreceive/bind-public','id'=>$model->id,'store_id'=>\Yii::$app->request->get("store_id")])]);

                    $html .= Html::a('清除绑定', ['/restaurant/dishreceive/clear','id'=>$model->id], ['class' => 'layui-btn layui-btn-mini layui-btn-danger clear-bind']);

                    return $html;

                },
                'format'=>'raw'
            ]
        ],
    ]); ?>
</div>


    <p style="font-weight: bolder;color: #ff5500;">
        *注意：每个门店最多3个收款通知人（收款通知人会收到所有的微信支付的订单信息），小程序设置结账的店员会收到设置的订单的收款通知，尽量少的设置收款通知人以保护收款流水的信息。<br/>必须关注公众号“橙蓝科技服务平台”才可以收到收款通知,扫码二维码关注！
    </p>
    <div class="msg" style="font-weight: bolder;">

        <img src="/uploads/chenglanapp.jpg" />
    </div>
<?php
$js = <<<JS

layui.use('layer',function(){
    var layer=layui.layer;
    
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
    
    jQuery(".clear-bind").click(function(e) {
        e.preventDefault();
        var href = jQuery(this).attr('href');
        layer.confirm('你确定要清除绑定吗', {icon: 3, title:'提示'}, function(index){
            location.href= href;
            return;
        });
    })
    
    
    
})

JS;

$this->registerJS($js);



?>