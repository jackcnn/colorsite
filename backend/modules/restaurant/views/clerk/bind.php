<?php
/**
 * Date: 2017/10/9 0009
 * Time: 18:55
 */

?>
<style>
.header-actions{display: none!important;}
#code{
    display: block;
    width:300px;
    height:300px;
    margin: 20px auto;
}
.msg{
    display: block;
    width:100%;
    height:45px;
    line-height: 45px;
    text-align: center;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    padding:0px 50px;
}
</style>


<div id="code"></div>

<div class="msg">使用微信扫码授权绑定帐号</div>


<?php

//$str = \yii\helpers\Url::to(['/site/bindclerk.html','store_id'=>$store_id,'clerk_id'=>$id,'token'=>$token],'https');
$str = \yii\helpers\Url::to(['/wxapp/dish','stid'=>$store_id.'-'.$id.'-BIND'],'https');
$str = str_replace("/admin","",$str);
$js = <<<JS

    var str = "{$str}";

    $('#code').qrcode({
			width: 300,

			height:300,

			text: str

		});


JS;

$this->registerJS($js);
$this->registerJsFile("/admin/vendor/jqrcode/jquery.qrcode.min.js",['position'=>\yii\web\View::POS_END,'depends'=>'yii\web\YiiAsset']);
?>