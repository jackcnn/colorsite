<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/14 0014
 * Time: 15:35
 */



?>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$store->name?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="/assets/reset.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
    <link href="/assets/preorder.css" rel="stylesheet">
    <style>
        .tableNo {
            display: inline-block;
            width: 50%;
            margin: 5px 3%;
            border: none;
            background-color: #f3f5f7;
            font-size: 14px;
            line-height: 18px;
            padding: 10px;
            color: #93999f;
        }
    </style>
</head>
<body>
<div>
    <div class="container">
        <div class="lister-container">
            <div class="lister">
                <div class="header">输入餐牌号</div>
            </div>
            <form id="form" action="<?=\Yii::$app->request->absoluteUrl?>" method="post">

                <div class="lister" style="text-align: center;">
                    <input class="tableNo" type="number" name="tableNo" placeholder="输入餐牌号" />
                </div>

            </form>


        </div>
    </div>

    <div>
        <div class="shopCart">
            <div class="content">
                <div class="content-left">
                    <div class="price active">
                        ￥555
                    </div>
                    <div class="desc">

                    </div>
                </div>
                <div id="submit" data-total="0" class="content-right enough">打印订单</div>
            </div>
        </div>
        <div class="backdrop"></div>
    </div>
</div>
</body>
<script src="/assets/jquery.js"></script>
<script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
<script>
    $(function () {
        $("#submit").click(function () {
            var tableNo = parseInt($("input[name=tableNo]").val());

            if(!tableNo){
                return $.alert("请填写桌号！");
            }

            $.confirm("确认下单吗？",function(){
                $("#form").submit();
            })

        })
    })
</script>
</html>