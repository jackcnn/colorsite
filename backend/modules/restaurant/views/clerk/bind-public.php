<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/25 0025
 * Time: 19:32
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
            /*height:45px;*/
            line-height: 45px;
            text-align: center;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding:0px 50px;
        }
    </style>

    <div id="code"></div>

    <div class="msg">
        使用微信扫码授权绑定,已方便接收到微信的收款通知<br/>
        <span style="color: #ff5500;font-weight: bolder;">注意：必须关注公众号"橙蓝科技服务平台"才能收到通知消息！关注二维码在下面。</span>
    </div>

    <div class="msg" style="font-weight: bolder;">
        橙蓝科技服务平台<br/>

        <img src="/uploads/chenglanapp.jpg" />
    </div>

<?php

$str = \yii\helpers\Url::to(['/dish/template/index.html','store_id'=>$store_id,'clerk_id'=>$id,'token'=>$token],'https');
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