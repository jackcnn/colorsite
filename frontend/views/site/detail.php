<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>美图蜘蛛</title>
    <!-- CSS  -->
    <link href="/assets/reset.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/assets/meitu/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<div class="container">
    <div class="detail-title"><?=$data['title']?></div>

    <div class="detail-content">
        <div class="detail-img-box">
            <?php if(count($list)){?>

                <?php foreach ($list as $key=>$value){?>
                    <img id="ix<?=$key?>" class="detail-imglist" src="<?=\yii\helpers\Url::to(['/site/img','url'=>$value])?>">
                <?php }?>

            <?php }?>
        </div>
    </div>

    <a class="detail-link" href="<?=$prev['router']?>"><?=$prev['title']?></a>
    <a class="detail-link" href="<?=$next['router']?>"><?=$next['title']?></a>
</div>
</body>
</html>
