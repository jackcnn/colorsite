<?php
/**
 * Date: 2017/10/11 0011
 * Time: 11:09
 */

?>
<html>
<head>
    <meta charset="utf-8">
    <title>sell</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <script src="/assets/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/reset.css">
    <link href="/assets/css.css" rel="stylesheet">
</head>
<body>
<div>
    <div class="header" style="background-image: url('<?=$store['logo']?>');"></div>

    <div class="tab_nav">
        <div class="tab_list">
            <a>菜品</a>
        </div>
        <div class="tab_list">
            <a>评论</a>
        </div>
    </div>
    <div>
        <div class="container">
            <div class="menu_wrapper">
                <div class="menu">
                    <ul class="menu_box">
                        <?php foreach($category as $key=>$value){?>
                            <li class="menu_item" data-id="<?=$value['id']?>">
                                <span class="text"><?=$value['name']?></span>
                            </li>
                        <?php }?>
                    </ul>
                </div>
            </div>

            <div class="foods_wrapper">
                <div class="foods">

                    <ul class="foods_box">
                        <?php foreach($category as $key=>$value){?>

                            <li class="foods_category category_h1_<?=$value['id']?>" data-key="<?=$key?>">
                                <h1><?=$value['name']?></h1>
                                <ul>
                                    <?php foreach($value['dishes'] as $k=>$v){?>

                                        <li class="foods_item">
                                            <div class="icon">
                                                <img width="57" height="57" src="<?=$v['cover']?>">
                                            </div>
                                            <div class="content">
                                                <h2><?=$v['name']?></h2>
                                                <p class="description"><?=$v['desc']?></p>
                                                <div class="sell-info">
                                                    <span class="sellCount">月售<?=$v['month_sales']?>份</span>
                                                    <span class="rating">好评率99%</span>
                                                </div>
                                                <div class="price">
                                                    <span class="newPrice"><span class="unit">￥</span><?=$v['price']/100?></span>
                                                    <span class="oldPrice" <?php if($v['oprice']<1){?>style="display: none;"<?php }?>>￥<?=$v['oprice']/100?></span></div>
                                                <div class="cartcontrol-wrapper">
                                                    <div class="cartcontrol">
                                                        <div class="cart-decrease">
                                                            <span class="icon-remove_circle_outline inner"></span>
                                                        </div>
                                                        <div class="cart-count">
                                                            1
                                                        </div>
                                                        <div class="cart-add"><i class="icon-add_circle"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                    <?php }?>
                                </ul>
                            </li>


                        <?php }?>
                    </ul>

                </div>

            </div>

        </div>


    </div>

</div>
</body>
<script>
$(function () {

    var list = new Array();

    $(".foods_category").each(function () {
        list.push($(this).offset().top)
    })
    var tt=0;
    console.log(list[tt]);


    $(".menu_item").click(function () {
        var self = $(this);
        if(!self.hasClass("menu_item_selected")){
            $(".menu_item").removeClass("menu_item_selected");
            self.addClass("menu_item_selected");

            var index = $(".category_h1_"+self.data("id")).data("key");


            $(".foods").animate({scrollTop: parseInt(list[index])-217 }, {duration: 500,easing: "swing"});
        }

    })
})
</script>
</html>
