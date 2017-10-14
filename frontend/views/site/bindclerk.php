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
    <style>
        .weui-icon-success{
            color: #00a0dc;
        }
        .weui-btn_primary{
            background-color: #00a0dc;
        }
    </style>
</head>
<body>
<div>



    <?php if(\Yii::$app->request->get("error")){?>


        <?php if(\Yii::$app->request->get("error") == 'had'){?>

            <div>
                <div class="weui-msg">
                    <div class="weui-msg__icon-area"><i class="weui-icon-error weui-icon_msg"></i></div>
                    <div class="weui-msg__text-area">
                        <h2 class="weui-msg__title">该微信已绑定过店员了</h2>
                    </div>
                </div>
            </div>

        <?php }else{?>

            <div>
                <div class="weui-msg">
                    <div class="weui-msg__icon-area"><i class="weui-icon-error weui-icon_msg"></i></div>
                    <div class="weui-msg__text-area">
                        <h2 class="weui-msg__title">绑定失败</h2>
                    </div>
                </div>
            </div>

        <?php }?>




    <?php }else{?>

        <?php if(\Yii::$app->request->get("success")){?>

            <div>
                <div class="weui-msg">
                    <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
                    <div class="weui-msg__text-area">
                        <h2 class="weui-msg__title">绑定成功</h2>
                    </div>
                </div>
            </div>

        <?php }else{?>

            <?php if($clerk->openid){?>

                <div>
                    <div class="weui-msg">
                        <div class="weui-msg__icon-area"><i class="weui-icon-error weui-icon_msg"></i></div>
                        <div class="weui-msg__text-area">
                            <h2 class="weui-msg__title">该店员记录已经被绑定了</h2>
                        </div>
                    </div>
                </div>

            <?php }else{?>

                <div>
                    <div class="weui-msg">
                        <div class="weui-msg__text-area">
                            <h2 class="weui-msg__title">绑定微信号</h2>
                            <p class="weui-msg__desc">绑定微信号为"<?=$store->name?>"店的"<?=$clerk->name?>"店员</p>
                        </div>
                        <form id="form" action="" method="post">
                            <div class="weui-msg__opr-area">
                                <p class="weui-btn-area">
                                    <a href="javascript:;" id="submit" class="weui-btn weui-btn_primary">确认绑定</a>
                                </p>
                            </div>

                        </form>

                    </div>
                </div>


            <?php }?>

        <?php }?>

    <?php }?>



</div>
</body>
<script src="/assets/jquery.js"></script>
<script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
<script>
$(function () {
    $("#submit").click(function () {
        $("#form").submit();
    })

})
</script>
</html>
