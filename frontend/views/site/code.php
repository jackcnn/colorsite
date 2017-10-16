<?php
/**
 * Date: 2017/10/16 0016
 * Time: 17:16
 */
?>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$store['name']?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="/assets/reset.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
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
</head>
<body>
<div>

    <div id="code"></div>

    <div class="msg">使用微信扫码点餐</div>
    <div class="msg"><?=$url?></div>

</div>
</body>
<script src="/assets/jquery.js"></script>
<script src="/admin/vendor/jqrcode/jquery.qrcode.min.js"></script>
<script>
    $(function () {
        var str = "<?=$url?>";

        $('#code').qrcode({
            width: 300,

            height:300,

            text: str

        });

    })
</script>
</html>
