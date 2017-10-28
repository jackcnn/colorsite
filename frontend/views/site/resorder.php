<?php
/**
 * Time: 11:09
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
</head>
<body>
<div>
    <div class="container">
        <div class="lister-container">
            <div class="lister">
                <div class="header"><?=$store->name?></div>
            </div>
            <?php foreach($carts as $key=>$value){?>
                <div class="lister">
                    <div class="header"><?=$value['name']?></div>
                    <ul class="content">
                        <?php foreach($value['dishes'] as $k=>$v){?>
                            <li class="lister-item">
                                <div class="name"><?=$v['name']?></div>
                                <div class="count">×<?=$v['order_count']?></div>
                                <div class="total">￥<?=$v['order_single_amount']/100?></div>
                                <div class="desc">
                                    <?=$v['order_labels']?>
                                </div>
                            </li>

                        <?php }?>
                        <?php if($value['mark']){?>
                            <li class="lister-item">
                                <div class="desc">
                                    备注：<?=$value['mark']?>
                                </div>
                            </li>
                        <?php }?>
                    </ul>
                </div>
            <?php }?>

        </div>
    </div>

    <div>
        <div class="shopCart">
            <div class="content">
                <div class="content-left">
                    <div class="price active">
                        ￥<?=$total/100?>
                    </div>
                    <div class="desc">
                        呼叫服务员下单
                    </div>
                </div>
                <div id="submit" data-total="0" class="content-right">呼叫下单</div>
            </div>
        </div>
        <div class="backdrop"></div>
    </div>
</div>
</body>
<script src="/assets/jquery.js"></script>
<script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
<script>
$(function(){
    $("#submit").click(function(){

        $.alert('点餐完成后呼叫服务员确认下单！');

    })
})
</script>
</html>



