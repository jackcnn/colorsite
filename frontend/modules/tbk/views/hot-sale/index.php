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
    <title></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="/assets/reset.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
    <link href="/assets/tbk/tbk-h5.css" rel="stylesheet">
</head>
<body>
<div>
    <div class="tbk-search">
        <div class="weui-search-bar" id="searchBar">
            <form class="weui-search-bar__form">
                <div class="weui-search-bar__box">
                    <i class="weui-icon-search"></i>
                    <input type="search" class="weui-search-bar__input" id="searchInput" placeholder="搜索" required="">
                    <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
                </div>
                <label class="weui-search-bar__label" id="searchText">
                    <i class="weui-icon-search"></i>
                    <span>搜索</span>
                </label>
            </form>
            <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
        </div>
    </div>
    <div class="tbk-banner">
        <div class="swiper-container" data-space-between='10' data-pagination='.swiper-pagination' data-autoplay="1000">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="/uploads/tbk/image/banner1.png" alt=""></div>
                <div class="swiper-slide"><img src="/uploads/tbk/image/banner2.png" alt=""></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <div class="tbk-nav-container">
        <div class="tbk-nav-scroll">
            <div class="tbk-nav-item active">男装</div>
            <div class="tbk-nav-item">男装</div>
            <div class="tbk-nav-item">男装</div>
            <div class="tbk-nav-item">男装</div>
            <div class="tbk-nav-item">男装</div>
            <div class="tbk-nav-item">男装</div>
            <div class="tbk-nav-item">男装</div>
            <div class="tbk-nav-item">男装</div>
        </div>
    </div>

    <div class="tbk-lister-container">
        <?php foreach($list as $key=>$value){?>

            <a href="<?=$value['coupon_url']?>" class="tbk-lister" data-clickurl="<?=$value['click_url']?>" data-couponurl="<?=$value['coupon_url']?>">
                <div class="tbk-lister-img">
                    <img src="<?=$value['main_pic']?>"  />
                </div>
                <div class="tbk-lister-content">
                    <div class="tbk-lister-title">
                        <?=$value['title']?>
                    </div>
                    <div class="tbk-lister-desc">
                        <div class="tbk-lister-price">月销<?=$value['sale']?>件</div>
                        <div class="tbk-lister-sale">优惠券：<?=$value['coupon_title']?></div>
                    </div>
                    <div class="tbk-lister-final">
                        <div class="tbk-lister-final-price">商品价格￥<span><?=$value['price']?></span></div>
                    </div>
                    <div class="tbk-lister-desc" style="position: relative;">
                        <div class="tbk-slide-bg"></div>
                        <div class="tbk-slide-cover" style="width:<?=(($value['coupon_total']-$value['coupon_remain'])/$value['coupon_total']*100)?>%;"></div>
                        <div class="tbk-slide-title">券| 余<?=$value['coupon_remain']?>张</div>
                    </div>
                    <div class="tbk-lister-mark">
                        券时间：<?=$value['startime']?>至<?=$value['endtime']?>
                    </div>
                </div>
            </a>

        <?php }?>
    </div>









</div>
</body>
<script src="/assets/jquery.js"></script>
<script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
<script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/swiper.min.js"></script>
<script src="https://cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>
<script>
$(function () {
    FastClick.attach(document.body);
    $(".swiper-container").swiper();
    var navFixed = false;
    $(document).on("scroll",function (e) {
        if($("body").scrollTop()>200){
            $(".tbk-nav-container").addClass("fixed-nav");
        }else{
            $(".tbk-nav-container").removeClass("fixed-nav");
        }
    })
})
</script>
</html>