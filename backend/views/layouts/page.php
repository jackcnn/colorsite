<?php
/**
 * Date: 2017/9/7 0007
 * Time: 16:23
 */
use backend\assets\AppAsset;
use yii\helpers\Html;
use backend\widgets\FooterWidget;
use backend\widgets\LayForm;
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
        <div class="layui-body" style="left: 0px;">
            <h1><?php if($AlertMsg=\Yii::$app->session->getFlash('AlertMsg')){echo $AlertMsg;}?></h1>
            <!-- 内容主体区域 -->
            <?= $content?>
        </div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>