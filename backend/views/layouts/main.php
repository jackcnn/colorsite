<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use backend\widgets\NavWidget;
use backend\widgets\HeaderWidget;
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

<div class="layui-layout layui-layout-admin">

    <?=HeaderWidget::widget()?>

    <?=NavWidget::widget()?>

    <div class="layui-body">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'options'=>['class'=>'layui-breadcrumb','lay-separator'=>'/','style'=>'display:block;padding:15px;'],
            'tag'=>'span',
            'itemTemplate' => "{link}\n",
            'activeItemTemplate' => "<a><cite>{link}</cite></a>\n"
        ]) ?>
        <!-- 内容主体区域 -->
        <div class="layui-container" style="width: 100%;">
            <?=$content?>
        </div>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © colorsite.com 陆荣泽
    </div>
</div>
<div class="color-loading">
    <i class="layui-icon layui-anim layui-anim-rotate layui-anim-loop">&#xe63d;</i><br/>
    <span>加载中...</span>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


