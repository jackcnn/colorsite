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
            'wxname',
            // 'wxpic',
            // 'openid',
            // 'is_receive',
            ['class' => 'yii\grid\ActionColumn'],
            [
                'attribute'=>'',
                'value'=>function($model){

                    $html = Html::a('公众号绑定', 'javascript:;', ['class' => 'layui-btn layui-btn-mini bind-public','data-href'=>\yii\helpers\Url::to(['/restaurant/dishreceive/bind-public','id'=>$model->id,'store_id'=>\Yii::$app->request->get("store_id")])]);

                    $html .= Html::a('清除绑定', ['/restaurant/dishreceive/clear','id'=>$model->id], ['class' => 'layui-btn layui-btn-mini layui-btn-danger']);

                    return $html;

                },
                'format'=>'raw'
            ]
        ],
    ]); ?>
</div>


    <p style="font-weight: bolder;color: #ff5500;">
        *注意每个门店最多3个收款通知人，必须关注公众号“橙蓝科技服务平台”才可以收到收款通知,扫码二维码关注！
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
    
    
    
})

JS;

$this->registerJS($js);



?>