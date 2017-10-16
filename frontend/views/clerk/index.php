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
                <div class="header">客人点单列表</div>
            </div>
            <form id="form" action="<?=\yii\helpers\Url::to(['clerk/order','sn'=>\Yii::$app->request->get("sn"),'token'=>$this->params['token'],'store_id'=>\Yii::$app->request->get("store_id")])?>" method="post">
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
                                <input type="hidden" name="dishes[<?=$value['id'].$v['id']?>][id]" value="<?=$v['id']?>" />
                                <input type="hidden" name="dishes[<?=$value['id'].$v['id']?>][name]" value="<?=$v['name']?>" />
                                <input type="hidden" name="dishes[<?=$value['id'].$v['id']?>][count]" value="<?=$v['order_count']?>" />
                                <input type="hidden" name="dishes[<?=$value['id'].$v['id']?>][labels]" value="<?=$v['order_labels']?>" />
                                <input type="hidden" name="dishes[<?=$value['id'].$v['id']?>][price]" value="<?=$v['price']?>" />

                            </li>

                        <?php }?>
                        <?php if($value['mark']){?>
                            <li class="lister-item">
                                <div class="desc">
                                    备注：<?=$value['mark']?>
                                </div>
                            </li>
                        <?php }?>
                        <input type="hidden" name="mark[<?=$value['id']?>]" value="<?=$value['mark']?>" />
                        <input type="hidden" name="openid[<?=$value['id']?>]" value="<?=$value['openid']?>" />
                    </ul>
            </div>
            <?php }?>


            <div class="lister" style="text-align: right;">
                    <input class="tableNo" type="number" name="tableNo" placeholder="请输入客人桌号" />
                    <input type="hidden" name="amount" value="<?=$total?>" />
            </div>

            </form>


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