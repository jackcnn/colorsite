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
    <link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
    <style>
        body{
            padding:90px 20px;
            box-sizing: border-box;
        }
        .demos-title{
            font-size:18px;
            color: #20A0FF;
            text-align: center;
        }
        #bind{
            margin-top:50px;
            width:50%;
        }
        .chenglan-logo{
            display: block;
            width:100%;
            text-align: center;
        }
    </style>
</head>
<body ontouchstart>
<header class='demos-header'>
    <h1 class="demos-title">确认绑定"<?=$store?>"的收款帐号，以接收公众号的模板消息吗？<span style="color: #ff5500;">（*绑定成功后，长按下方二维码关注公众号才可以接收到消息）</span></h1>
</header>

<div class='demos-content-padded'>
    <a id="bind" href="javascript:;" class="weui-btn weui-btn_primary">确认绑定</a>
</div>

<div class="chenglan-logo">
    <img src="/uploads/chenglan.jpg" />
</div>

</body>
<script src="/assets/jquery.js"></script>
<script src="https://cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>
<script src="https://cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
<script>
$(function () {
    FastClick.attach(document.body);

    $("#bind").click(function () {
        $.showLoading();

        $.post(location.href,{
            openid:'<?=$res['openid']?>',
            wxname:'<?=$res['wxname']?>',
            wxpic:'<?=$res['wxpic']?>'
        },function (res) {
            $.hideLoading();
            $.alert(res.msg);
        })

    })


})
</script>
</html>
