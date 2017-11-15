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
    <title>淘宝天猫内部优惠发放平台</title>
    <meta name="description" content="淘宝天猫内部优惠发放平台,每日更新优惠商品，速度围观！">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="/assets/reset.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
    <link href="/assets/tbk/tbk-h5.css" rel="stylesheet">
</head>
<body>
<img style="display: none;" src="/uploads/tbk/image/banner1.png" alt="">
<div id="main-body">
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
            <div class="tbk-nav-item active">全网热销</div>
            <div class="tbk-nav-item" data-kw="女装">女装</div>
            <div class="tbk-nav-item" data-kw="女鞋">女鞋</div>
            <div class="tbk-nav-item" data-kw="男装">男装</div>
            <div class="tbk-nav-item" data-kw="男鞋">男鞋</div>
            <div class="tbk-nav-item" data-kw="美容">美容</div>
            <div class="tbk-nav-item" data-kw="运动">运动</div>
            <div class="tbk-nav-item" data-kw="饰品">饰品</div>
            <div class="tbk-nav-item" data-kw="孕妇">孕妇</div>
            <div class="tbk-nav-item" data-kw="食品">食品</div>
            <div class="tbk-nav-item" data-kw="玩具">玩具</div>
            <div class="tbk-nav-item" data-kw="零食">零食</div>
        </div>
    </div>

    <div class="tbk-lister-container">
        <?php foreach($list as $key=>$value){?>
            <div class="tbk-lister" data-model="" data-clickurl="<?=$value['click_url']?>" data-couponurl="<?=$value['coupon_surl']?>">
                <div class="tbk-lister-img">
                    <img src="<?=$value['main_pic']?>"  />
                </div>
                <div class="tbk-lister-content">
                    <div class="tbk-lister-title">
                        <?=$value['title']?>
                    </div>
                    <div class="tbk-lister-desc">
                        <div class="tbk-lister-price">优惠券：<?=$value['coupon_title']?></div>
                        <div class="tbk-lister-sale">月销<?=$value['sale']?>件</div>
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
            </div>
        <?php }?>


    </div>
    <div class="weui-loadmore" style="display: none;">
        <i class="weui-loading"></i>
        <span class="weui-loadmore__tips">正在加载</span>
    </div>
    <div class="tbk-loadmore">
        点击加载更多
    </div>

</div>

<div class="clipboard">
    <div class="tbk-clipboard" data-clipboard-text="sss">
        <div class="tbk-kl-title">sssss</div>
        <div class="tbk-kl-msg">淘口令生成成功！</div>
        <div class="tbk-kl-btn">复制到剪贴板</div>
    </div>
</div>

</body>
<script src="/assets/jquery.js"></script>
<script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/swiper.min.js"></script>
<script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
<script src="https://cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>
<script src="https://cdn.bootcss.com/clipboard.js/1.5.16/clipboard.min.js"></script>
<script>
$(function () {
    FastClick.attach(document.body);

    clipboard = new Clipboard('.tbk-clipboard');

    clipboard.on('success', function(e) {
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);
        $(".clipboard").hide();
        e.clearSelection();
        $.alert("复制成功！打开手机淘宝即可领取优惠！");
    });

    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
        $.alert("复制失败...请手动选择口令复制！");
    });

    var navFixed = false;
    $(document).on("scroll",function (e) {
        if($("body").scrollTop()>200){
            $(".tbk-nav-container").addClass("fixed-nav");
        }else{
            $(".tbk-nav-container").removeClass("fixed-nav");
        }

    })
    var loading = false;  //状态标记
    var page = 2;
    var kw = '';
    $(".tbk-loadmore").on("click",function () {
        if(loading) return;
        $(".weui-loadmore").show();
        $(".tbk-loadmore").hide();
        loading = true;
        $.get("<?=\yii\helpers\Url::to(['/tbk/hot-sale/lists'])?>",{
            page:page,
            kw:kw
        },function (data) {
            if(data){
                $(".weui-loadmore").hide();
                $(".tbk-loadmore").show();
                $(".tbk-lister-container").append(data);
                loading = false;
                page = page+1;
            }else{
                $(".weui-loadmore").hide();
                $(".tbk-loadmore").hide();
            }
        })
    })


    $(".tbk-nav-item").on("click",function () {
        if(loading) return;

        $(".tbk-lister-container").html('');
        page =1;
        kw = $(this).data("kw");

        $(".tbk-nav-item").removeClass("active");
        $(this).addClass("active")
        $(".weui-loadmore").show();
        $(".tbk-loadmore").hide();
        loading = true;
        $.get("<?=\yii\helpers\Url::to(['/tbk/hot-sale/lists'])?>",{
            page:page,
            kw:kw
        },function (data) {
            if(data){
                $(".weui-loadmore").hide();
                $(".tbk-loadmore").show();
                $(".tbk-lister-container").append(data);
                loading = false;
                page = page+1;
            }else{
                $(".weui-loadmore").hide();
                $(".tbk-loadmore").hide();
            }
        })
    })


    //clipboard-text
    $(document).on("click",".tbk-lister",function () {
        console.log(123123)
        var self = $(this);
        if(self.data('model')){

            var html='<div class="tbk-clipboard" data-clipboard-text="'+self.data('model')+'">\n' +
                '        <div class="tbk-kl-title">'+self.data('model')+'</div>\n' +
                '        <div class="tbk-kl-msg">淘口令生成成功！</div>\n' +
                '        <div class="tbk-kl-btn">复制到剪贴板</div>\n' +
                '    </div>';
            $(".clipboard").html(html);
            $(".clipboard").show();

        }else{
            $.showLoading('生成中...');

            $.get("<?=\yii\helpers\Url::to(['/tbk/hot-sale/koulin'])?>",{
                url:self.data("couponurl"),
            },function (res) {
                self.data("model",res.data);
                $.hideLoading();
                var html='<div class="tbk-clipboard" data-clipboard-text="'+res.data+'">\n' +
                    '        <div class="tbk-kl-title">'+res.data+'</div>\n' +
                    '        <div class="tbk-kl-msg">淘口令生成成功！</div>\n' +
                    '        <div class="tbk-kl-btn">复制到剪贴板</div>\n' +
                    '    </div>';
                $(".clipboard").html(html);
                $(".clipboard").show();
            })
        }
    })


    $(".swiper-container").swiper();


})
</script>
</html>