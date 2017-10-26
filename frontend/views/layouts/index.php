<?php
/**
 * Date: 2017/10/23
 * Time: 9:58
 */

use yii\helpers\Html;
use frontend\assets\IndexAsset;

IndexAsset::register($this);
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

    <?= $content ?>

    <footer class="page-footer orange">

        <div class="footer-copyright">
            <div class="container">
                Made by <a class="orange-text text-lighten-3" href="https://326108993.com">橙蓝科技</a>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>