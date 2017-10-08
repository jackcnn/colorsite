<?php

use yii\helpers\Html;
use yii\grid\GridView;
$this->title = '订单列表';

$this->params['breadcrumbs'][] = ['label'=>'点餐系统','url'=>['/restaurant/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['tabs']['list']=backend\models\ShareData::tabslist('restaurant');
?>
