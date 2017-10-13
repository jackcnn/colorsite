<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/12 0012
 * Time: 17:00
 */
?>
<?php
/**
 * Date: 2017/10/11 0011
 * Time: 11:09
 */

?>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$store['name']?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <script src="/assets/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/reset.css">
    <link href="/assets/preorder.css" rel="stylesheet">
</head>
<body>
<div>
    <div class="container">
        <div class="lister-container">
            <div class="lister">
                <div class="header"><?=$store->name?></div>
                <ul class="content">
                    <?php foreach($dishes as $key=>$value){?>
                        <li class="lister-item">
                            <div class="name"><?=$value['name']?></div>
                            <div class="count">×<?=$value['order_count']?></div>
                            <div class="total">￥<?=$value['order_single_amount']/100?></div>
                            <div class="desc">
                                <?php foreach($value['labels'] as $k=>$v){?>
                                    <span class="labels"><?=$v?></span>
                                <?php }?>
                            </div>
                        </li>
                    <?php }?>
                </ul>
            </div>
            <div class="lister">
                <div class="mark-container">
                    <textarea class="mark" name="mark" placeholder="请输入备注内容（可不填）"></textarea>
                </div>
            </div>
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
                        已点列表
                    </div>
                </div>
                <div id="submit" data-total="0" class="content-right enough">去支付</div>
            </div>
        </div>
        <div class="backdrop"></div>
    </div>


</div>
</body>
</html>



