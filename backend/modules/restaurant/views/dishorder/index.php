<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DishorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishorder-index">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'store_id',
                'value'=>'store.name',
                'label'=>'所属门店',
                'filter'=>$stores
            ],
            'ordersn',
             [
                 'attribute'=>'status',
                 'label'=>'订单状态',
                 'value'=>function($model){
                    $data = ['0'=>'下单','1'=>'等待付款','2'=>'已付款'];
                    return $data[$model->status];
                 },
                 'filter'=>['0'=>'下单','1'=>'等待付款','2'=>'已付款']
             ],
             [
                 'attribute'=>'amount',
                 'label'=>'订单金额',
                 'value'=>function($model){
                    return ($model->amount/100)."元";
                 }
             ],
             [
                 'attribute'=>'paytime',
                 'value'=>function($model){
                    return $model->paytime>0?date("Y-m-d H:i:s",$model->paytime):'';
                 },
                 'label'=>'付款时间'
             ],
             [
                 'attribute'=>'payopenid',
                 'value'=>'payname.wxname',
                 'label'=>'付款人'
             ],
             [
                 'attribute'=>'paytype',
                 'label'=>'支付方式',
                 'value'=>function($model){
                     switch($model->paytype){
                         case 'wxpay':
                             return "微信支付";break;
                         case 'cash':
                             return "现金支付";break;
                         default:
                             return "其他支付方式";break;
                     }
                 }
             ],
             'table_num',
             [
                 'attribute'=>'created_at',
                 'label'=>'下单时间',
                 'value'=>function($model){
                     return date("Y-m-d H:i:s",$model->created_at);
                 },
             ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}'
            ],
        ],
    ]); ?>
</div>
