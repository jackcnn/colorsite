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
    <div class="detail-title">信息反馈</div>

    <div class="row">
        <?php if($msg){?>

            <div class="sub-block">
                <div class="label"><?=urldecode($msg)?></div>
                <br/><br/><br/>
                <a href="<?=\yii\helpers\Url::to(['/site/submit'])?>">重新提交</a>
            </div>

        <?php }else{?>

            <div class="col">
                <form method="post">
                    <div class="sub-block">
                        <div class="label">要反馈的内容的链接</div>
                        <div class="input"><input name="link" type="text" value="" /></div>
                    </div>
                    <div class="sub-block">
                        <div class="label">描述</div>
                        <div class="textarea"><textarea name="desc"></textarea></div>
                    </div>
                    <div class="sub-block" style="text-align: center;margin-top: 25px;">
                        <input class="submit" type="submit" value="提交" />
                    </div>
                </form>
            </div>

        <?php }?>
    </div>
</div>
</body>
</html>
