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
    <link href="/assets/materialize/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/assets/meitu/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<div class="container">

    <heade class="header">
        美图蜘蛛

    </heade>

    <?php foreach ($list as $key=>$value){?>
        <div class="row">
            <?php foreach($value as $k=>$v){?>
                <div class="col s12 m3">
                    <a target="_blank" href="<?=\yii\helpers\Url::to(['/site/detail','id'=>$v['id']])?>" class="list">
                        <div class="img-box">
                            <img src="<?=\yii\helpers\Url::to(['/site/img','url'=>$v['logo']])?>">
                        </div>
                        <div class="img-title"><?=$v['title']?></div>
                    </a>
                </div>
            <?php }?>
        </div>
    <?php }?>

    <div class="row">
        <div class="page-container">
            <a class="pager  <?=$pager['cur']==1?'cur':''?>" href="<?=\yii\helpers\Url::to(['/site/index','page'=>1])?>">首页</a>
            <?php for($i=$pager['start'];$i<$pager['end']+1;$i++){?>
                <a class="pager  <?=$pager['cur']==$i?'cur':''?>" href="<?=\yii\helpers\Url::to(['/site/index','page'=>$i])?>"><?=$i?></a>
            <?php }?>
            <a class="pager <?=$pager['cur']==$pager['total']?'cur':''?>" href="<?=\yii\helpers\Url::to(['/site/index','page'=>$pager['total']])?>">尾页</a>
            <a href="javascript:;">共<?=$pager['total']?>页</a>
        </div>
    </div>
    <div class="row" style="text-align: center;color: #999999;padding: 15px 0px;">
        本网站内容来源于互联网，如有侵犯版权请来信告知,我们将立即处理。<a target="_blank" href="<?=\yii\helpers\Url::to(['/site/submit'])?>">(点我发送信息告知)</a>
    </div>
</div>
</body>
</html>
