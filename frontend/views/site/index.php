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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.2/css/swiper.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.2/css/swiper.min.css">
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






            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach($category as $key=>$value){?>

                        <div class="swiper-slide foods_category category_h1_<?=$value['id']?>" data-key="<?=$key?>">
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
                                                    <div class="cart-decrease" style="display: none;">
                                                        <span class="icon-remove_circle_outline inner"></span>
                                                    </div>
                                                    <div class="cart-count" data-price = "<?=$v['price']?>" style="display: none;">0</div>
                                                    <div class="cart-add"><i class="icon-add_circle"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                <?php }?>
                            </ul>
                        </div>


                    <?php }?>


                </div>
            </div>



        </div>


    </div>

</div>
</body>
<script src="/assets/swiper-3.4.2.jquery.min.js"></script>
<script>
    $(function () {
//        var list = new Array();
//        $(".foods_category").each(function () {
//            list.push($(this).offset().top)
//        })
//        $(".menu_item").click(function () {
//            var self = $(this);
//            if(!self.hasClass("menu_item_selected")){
//                $(".menu_item").removeClass("menu_item_selected");
//                self.addClass("menu_item_selected");
//                var index = $(".category_h1_"+self.data("id")).data("key");
//                $(".foods").animate({scrollTop: parseInt(list[index])-217 }, {duration: 300,easing: "swing"});
//            }
//        })

        var mySwiper = new Swiper ('.swiper-container', {
            direction: 'vertical',
            loop: false,
            freeMode : true,
        })



        //购物车相关
        $(".cart-add").click(function () {
            var self = $(this);
            var target = self.parent().find(".cart-count");
            var res = parseInt(target.html())+1;
            target.html(res);
            if(res > 0){
                self.parent().find(".cart-decrease").show();
                target.show();
            }

            get_result();
        })

        $(".cart-decrease").click(function () {
            var self = $(this);
            var target = self.parent().find(".cart-count");
            var res = parseInt(target.html())-1;
            target.html(res);
            if(res < 1){
                self.hide();
                target.hide();
            }

            get_result();

        })

        function get_result()
        {
            var count = 0;
            var total = 0;
            $(".foods_category .cart-count").each(function () {
                count = parseInt($(this).html()) + count ;

                total = parseInt($(this).data("price")*parseInt($(this).html()))+total;
            })

            $(".shopCart .badge").html(count);
            $(".shopCart .price").html("￥"+total/100);

        }

    })
</script>
</html>
