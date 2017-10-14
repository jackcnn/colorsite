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
    <link rel="stylesheet" type="text/css" href="/assets/reset.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">

    <link href="/assets/css.css" rel="stylesheet">
</head>
<body>
<div>
    <div class="header" style="display:none;background-image: url('<?=$store['logo']?>');"></div>

    <div class="tab_nav" style="display: none;">
        <div class="tab_list">
            <a>菜品</a>
        </div>
        <div class="tab_list">
            <a>评论</a>
        </div>
    </div>
    <div>
        <div class="container"  style="top: 0px;">
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
                                                    <span class="rating" style="display: none;">好评率99%</span>
                                                </div>
                                                <div class="price">
                                                    <span class="newPrice"><span class="unit">￥</span><?=$v['price']/100?></span>
                                                    <span class="oldPrice" <?php if($v['oprice']<1){?>style="display: none;"<?php }?>>￥<?=$v['oprice']/100?></span></div>
                                                <div class="cartcontrol-wrapper">
                                                    <div class="cartcontrol">
                                                        <div class="cart-decrease" <?php if($v['hascount']<1){?>style="display: none;"<?php }?>>
                                                            <span class="icon-remove_circle_outline inner"></span>
                                                        </div>
                                                        <div class="cart-count" id="foodID_<?=$v['id']?>" data-id="<?=$v['id']?>" data-price = "<?=$v['price']?>" <?php if($v['hascount']<1){?>style="display: none;"<?php }?>>
                                                            <?=$v['hascount']?>
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

            <div>
                <div class="shopCart">
                    <div class="content">
                        <div class="content-left">
                            <div class="logo-wrapper">
                                <div class="badge">
                                    0
                                </div>
                                <div class="logo active"><i class="icon-shopping_cart"></i></div>
                            </div>
                            <div class="price active">
                                ￥0
                            </div>
                            <div class="desc">
                                已点列表
                            </div>
                        </div>
                        <div id="submit" data-total="0" class="content-right">提交</div>
                    </div>

                    <div class="shopcart-list" style="display: none;">
                        <div class="list-header"><h1 class="title"><?php if(!\Yii::$app->user->isGuest){echo \Yii::$app->user->identity->wxname;}?></h1> <span class="empty">清空</span></div>
                        <div class="list-content">
                            <ul>
                                <?php foreach($dishes as $key=>$value){?>

                                    <li class="food" id="cartlist_fid_<?=$value['id']?>">
                                        <span class="name"><?=$value['name']?></span>
                                        <div class="price"><span>￥0</span></div>
                                        <div class="cartcontrol-wrapper">
                                            <div class="cartcontrol">
                                                <div class="cart-decrease" data-price="<?=$value['price']?>" data-fid="<?=$value['id']?>"><span class="icon-remove_circle_outline inner"></span></div>
                                                <div class="cart-count">
                                                    0
                                                </div>
                                                <div class="cart-add" data-price="<?=$value['price']?>" data-fid="<?=$value['id']?>"><i class="icon-add_circle"></i></div>
                                            </div>
                                        </div>
                                    </li>


                                <?php }?>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="backdrop"></div>
            </div>
        </div>

    </div>

</div>
</body>
<script src="/assets/jquery.js"></script>
<script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
<script>
    $(function () {
        var scroll_list = new Array();
        $(".foods_category").each(function () {
            scroll_list.push($(this).offset().top)
        })
        $(".menu_item").click(function () {
            var self = $(this);
            if(!self.hasClass("menu_item_selected")){
                $(".menu_item").removeClass("menu_item_selected");
                self.addClass("menu_item_selected");
                var index = $(".category_h1_"+self.data("id")).data("key");
                $(".foods").animate({scrollTop: parseInt(scroll_list[index]) }, {duration: 300,easing: "swing"});
            }
        })

        get_result();

        //购物车相关

        $(".foods_category .cart-add").click(function () {//菜品点击增加
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

        $(".foods_category .cart-decrease").click(function () {//菜品点击减少
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

        $(".content-left").click(function () {
            $(".shopcart-list .food").hide();

            $(".foods_category .cart-count").each(function(){
                var self = $(this);
                var count = parseInt(self.html());
                var id = parseInt(self.data("id"));
                var price = parseInt(self.data("price"));
                var obj = $("#cartlist_fid_"+id);
                if(count > 0){
                    obj.show();
                    obj.find(".cart-count").html(count);
                    obj.find(".price span").html("￥"+parseInt(count*price)/100);
                }
            })

            $(".shopcart-list").slideToggle();
            $(".backdrop").toggle();
        })


        $(".shopcart-list .cart-add").click(function () {//点餐清单里面点击的
            var self = $(this);
            var target = self.parent().find(".cart-count");
            var res = parseInt(target.html())+1;
            target.html(res);

            var fid = self.data("fid");
            var object = $("#foodID_"+fid);
            object.html(res);

            self.parent().parent().parent().find(".price span").html("￥"+parseInt(self.data("price")*res)/100);

            if(res > 0){
                self.parent().find(".cart-decrease").show();
                target.show();

                object.parent().find(".cart-decrease").show();
                object.parent().find(".cart-count").show();
            }
            get_result();
        })

        $(".shopcart-list .cart-decrease").click(function () {//菜品点击减少
            var self = $(this);
            var target = self.parent().find(".cart-count");
            var res = parseInt(target.html())-1;
            target.html(res);

            var fid = self.data("fid");
            var object = $("#foodID_"+fid);
            object.html(res);

            self.parent().parent().parent().find(".price span").html("￥"+parseInt(self.data("price")*res)/100);

            if(res < 1){
                self.hide();
                target.hide();
                self.parent().parent().parent().fadeOut();
                object.parent().find(".cart-decrease").hide();
                object.parent().find(".cart-count").hide();

            }

            get_result();

        })


        $(".list-header .empty").click(function () {//清空菜单

            $(".foods_category .cart-count").each(function(){
                var self = $(this);
                self.html(0);
                self.parent().find(".cart-decrease").hide();

            })
            $(".shopcart-list .food").hide();
            get_result()
        })

        $("#submit").click(function () {

            var self = $(this);
            if(!self.hasClass("enough")){
                return false;
            }

            var list = new Array();

            $(".foods_category .cart-count").each(function(){
                var count = parseInt($(this).html());
                if(count > 0){
                    var id = $(this).data("id");
                    list.push(id+"-"+count);
                }
            })


            $.ajax({
                url: "<?=\yii\helpers\Url::toRoute(['site/cookiesorder','token'=>$this->params['token'],'store_id'=>$store['id']])?>",
                type:"post",
                data:{
                    'list':list,
                    'amount':$("#submit").data("total"),
                    'sn':'<?=\Yii::$app->request->get("sn")?>',
                },
                dataType:"json",
                beforeSend:function(){
                },
                complete:function(){
                },
                error:function (XMLHttpRequest, textStatus, errorThrown){
                    alert("网络错误,请重试...");
                },
                success: function(data){
                    if(data.location){
                        return location.href=data.location;
                    }
                }
            });


        })



        function get_result()
        {
            var count = 0;
            var total = 0;
            $(".foods_category .cart-count").each(function () {
                count = parseInt($(this).html()) + count ;
                total = parseInt($(this).data("price")*parseInt($(this).html()))+total;
            })

            if(count > 0){
                $("#submit").addClass("enough");
            }else{
                $("#submit").removeClass("enough");
            }

            $(".shopCart .badge").html(count);
            $(".shopCart .content-left .price").html("￥"+total/100);
            $("#submit").data("total",total);

        }


    })
</script>
</html>
