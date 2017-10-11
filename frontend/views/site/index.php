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
                            <li class="menu_item">
                                <span class="text"><?=$value['name']?></span>
                            </li>
                        <?php }?>
                    </ul>
                </div>
            </div>

            <div class="foods_wrapper">
                <div class="foods">

                    <ul class="foods_box">

                        <li class="foods_category">
                            <h1>主食</h1>
                            <ul>
                                <li class="foods_item">
                                    <div class="icon">
                                        <img width="57" height="57" src="http://fuss10.elemecdn.com/d/2d/b1eb45b305635d9dd04ddf157165fjpeg.jpeg?imageView2/1/w/114/h/114">
                                    </div>
                                    <div class="content">
                                        <h2>娃娃菜炖豆腐</h2>
                                        <p class="description">新鲜娃娃菜加新鲜豆腐</p>
                                        <div class="sell-info">
                                            <span class="sellCount">月售43份</span>
                                            <span class="rating">好评率92%</span>
                                        </div>
                                        <div class="price">
                                            <span class="newPrice"><span class="unit">￥</span>17</span>
                                            <span class="oldPrice">￥20</span></div>
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
                            </ul>
                        </li>

                    </ul>

                </div>

            </div>

        </div>


    </div>

</div>
</body>
</html>
