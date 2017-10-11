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
            <div class="menu">

                <?php for($i=0;$i<30;$i++){?>
                    <div class="menu_item">

                        <span class="text">热卖单品</span>

                    </div>
                <?php }?>


            </div>

        </div>





    </div>

</div>
</body>
</html>
