<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/15 0015
 * Time: 13:00
 */

?>
<html>
<head>
    <meta charset="utf-8">
    <title>下单结果</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="/assets/reset.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
    <style>
        .weui-icon-success{
            color: #00a0dc;
        }
        .weui-btn_primary{
            background-color: #00a0dc;
        }
        .weui-btn_primary:not(.weui-btn_disabled):active {
            color: hsla(0,0%,100%,.6);
            background-color: #00a0dc;
        }
    </style>
</head>
<body>
<div>

    <div>
        <div class="weui-msg">
            <div class="weui-msg__icon-area"><i class="weui-icon-<?=\Yii::$app->request->get("type")?> weui-icon_msg"></i></div>
            <div class="weui-msg__text-area">
                <h2 class="weui-msg__title"><?=urldecode(\Yii::$app->request->get("msg"))?></h2>
            </div>
        </div>
    </div>




</div>
</body>
<script src="/assets/jquery.js"></script>
<script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
</html>
