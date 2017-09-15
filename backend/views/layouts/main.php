<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use backend\widgets\NavWidget;
use backend\widgets\HeaderWidget;
use backend\widgets\FooterWidget;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="layui-layout">

    <div class="layui-body colorsite-body-left-0">
        <div style="float: right;display: block;padding: 15px;">
            <a class="layui-btn layui-btn-mini" href="javascript:history.back(-1);" title="返回" aria-label="返回"><i class="layui-icon">&#xe65c;</i>返回</a>
            <a class="layui-btn layui-btn-mini" href="javascript:location.reload();" title="刷新" aria-label="刷新"><i class="layui-icon">&#x1002;</i>刷新</a>
            <a class="layui-btn layui-btn-mini" target="_blank" href="<?=\Yii::$app->request->absoluteUrl?>" title="新标签打开" aria-label="新标签打开" data-pjax="0"><i class="layui-icon">&#xe641;</i>新标签打开</a>
        </div>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'options'=>['class'=>'layui-breadcrumb','lay-separator'=>'/','style'=>'display:block;padding:15px;'],
            'tag'=>'span',
            'homeLink'=>['label'=>'首页','url'=>['/site/home']],
            'itemTemplate' => "{link}\n",
            'activeItemTemplate' => "<a><cite>{link}</cite></a>\n"
        ]) ?>
        <?= backend\widgets\LayTabs::widget([
                'list'=>isset($this->params['tabs']['list'])?$this->params['tabs']['list'] : [],
                'active'=>isset($this->params['tabs']['active'])?$this->params['tabs']['active'] : '',
        ])?>
        <!-- 内容主体区域 -->
        <div class="layui-container" style="width: 100%;">
            <?=$content?>
        </div>
    </div>
</div>
<div class="color-loading">
    <i class="layui-icon layui-anim layui-anim-rotate layui-anim-loop">&#xe63d;</i><br/>
    <span>加载中...</span>
</div>
<?php $this->endBody() ?>
<?php
$alert = \Yii::$app->session->getFlash('AlertMsg');
$err = \Yii::$app->session->getFlash('ErrMsg');
if($alert){
$alert_js =<<<JS
layui.use('layer',function(){
    var layer=layui.layer;
    layer.msg("$alert",{offset:'t'});
})
JS;
$this->registerJs($alert_js);
}
if($err){
$err_js =<<<JS
layui.use('layer',function(){
    var layer=layui.layer;
    layer.msg("$err", {icon: 5,offset:'t'});
})
JS;
$this->registerJs($err_js);
}
?>
</body>
</html>
<?php $this->endPage() ?>


