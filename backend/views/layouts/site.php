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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="layui-layout layui-layout-admin">
    <?=HeaderWidget::widget()?>
    <?=NavWidget::widget()?>
    <div class="layui-body" style="overflow:hidden;">
        <iframe  src="<?=\yii\helpers\Url::to(['/site/home'])?>" id="colorsit-iframe" name="colorsit-iframe" width="100%" height="100%" frameborder="0"></iframe>
    </div>
    <?=FooterWidget::widget()?>
</div>
<?php $this->endBody() ?>
</body>
<script>
jQuery(function(){
jQuery(".layui-logo").click(function () {
    jQuery(".layui-side").toggle();
    jQuery(".layui-footer").toggleClass("colorsite-body-left-0");
    jQuery(".layui-body").toggleClass("colorsite-body-left-0");
})
})
</script>
</html>
<?php $this->endPage() ?>