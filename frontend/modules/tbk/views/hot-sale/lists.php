<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14 0014
 * Time: 17:50
 */
?>
<?php foreach($list as $key=>$value){?>
    <div class="tbk-lister" data-clickurl="<?=$value['click_url']?>"  data-model="" data-couponurl="<?=$value['coupon_surl']?>">
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
