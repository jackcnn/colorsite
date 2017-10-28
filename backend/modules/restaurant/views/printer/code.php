<?php
/**
 * Created by PhpStorm.
 * User: lurongze
 * Date: 2017/10/28
 * Time: 12:15
 */

?>
<div id="headerss">
<h3>扫描二维码进入打印页面，可保存链接方便下次打开</h3>
    <div id="code"></div>

</div>

<?php
$str = \yii\helpers\Url::to(['/clerk/print-code'],true);
$str = str_replace("/admin","",$str).".html?token=".\Yii::$app->user->identity->token;

$js = <<<JS

	$('#code').qrcode("{$str}");

JS;

$this->registerJS($js);
$this->registerJSFile('/admin/vendor/jqrcode/jquery.qrcode.min.js',['position' => \yii\web\View::POS_END,'depends'=>'\yii\web\YiiAsset']);

?>

<style>
    #code{
        display: block;
        margin:20px auto;
        width:270px;
    }
    .header-actions{display: none!important;}
    #headerss h3{
        display: block;
        text-align: center;
        padding:20px;
    }
</style>
