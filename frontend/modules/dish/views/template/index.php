<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/25 0025
 * Time: 20:34
 */

?>
<html>
<head>
    <meta charset="utf-8">
    <title>橙蓝网络科技服务平台</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="/assets/reset.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
</head>
<body ontouchstart>
<header class='demos-header'>
    <h1 class="demos-title">确认绑定店员帐号接收公众号的模板消息吗？</h1>
</header>

<div class='demos-content-padded'>
    <a id="bind" href="javascript:;" class="weui-btn weui-btn_primary">确认绑定</a>
</div>

</body>
<script src="/assets/jquery.js"></script>
<script src="https://cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>
<script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
<script>
$(function () {
    FastClick.attach(document.body);

    $("#bind").click(function () {
        $.showLoading();

        $.post(location.href,{
            openid:'<?=$openid?>'
        },function (res) {
            $.hideLoading();
            $.alert(res.msg);
        })

    })


})
</script>
</html>
