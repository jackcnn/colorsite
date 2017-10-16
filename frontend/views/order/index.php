<?php
/**
 * Date: 2017/10/15 0015
 * Time: 16:45
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
    <link href="/assets/preorder.css" rel="stylesheet">
    <style>
        .tableNo {
            display: inline-block;
            width: 30%;
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
                <div class="header">点单详细</div>
                <ul class="content">
                    <?php foreach($order['dishes'] as $key=>$value){?>
                        <li class="lister-item">
                            <div class="name"><?=$value['name']?></div>
                            <div class="count">×<?=$value['count']?></div>
                            <div class="total">￥<?=intval($value['count']*$value['price'])/100?></div>
                            <div class="desc">
                                <?=$value['labels']?>
                            </div>
                        </li>
                    <?php }?>

                    <li class="lister-item">
                        <div class="desc">
                            <?php foreach($marks as $key=>$value){?>
                                备注：<?=$value?><br/>
                            <?php }?>
                        </div>
                    </li>


                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="shopCart">
            <div class="content">
                <div class="content-left">
                    <div class="price active">
                        ￥<?=$order['amount']/100?>
                    </div>
                    <div class="desc">
                        买单呼叫服务员
                    </div>
                </div>
                <?php switch(intval($order['status'])){
                    case 0:
                        ?><div id="submit0" data-total="0" style="background: #2b343c;" class="content-right">已下单</div><?php
                        break;
                    case 1:
                        ?><div id="submit1" data-total="0" class="content-right enough">付款</div><?php
                        break;
                    case 2:
                        ?><div id="submit2" data-total="0" class="content-right enough">已付款</div><?php
                        break;
                }?>
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
    $("#submit0").click(function () {
        $.alert("呼叫服务员结账后刷新页面或重新扫码进行支付！");
    })
    $("#submit1").click(function(){

        $.actions({
            actions: [
            {
                text: "微信支付(￥<?=$order['amount']/100?>)",
                onClick: function() {
                    //do something
                }
            },
            ]
        });
    })
})
</script>
</html>
