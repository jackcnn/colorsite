<?php
/**
 * Created by PhpStorm.
 * User: lurongze
 * Date: 2017/10/28
 * Time: 14:08
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
    <style>
        .container{
            padding:20px;
        }
        .demos-header{
        }
        .demos-title{
            display: block;
            width:100%;
            text-align: center;
            font-size:24px;
            font-weight: bold;
            padding:15px 0px;
        }
        .demos-min-title{
            display: block;
            width:100%;
            text-align: left!important;
            font-size: 14px!important;
            padding:15px 0px;
        }
    </style>
</head>
<body>
<div>
    <div class="container">
        <div class='demos-header'>
            <div class="demos-title">打印点餐码页面</div>
            <div class="demos-min-title">门店：<?=$store->name?></div>
            <div class="demos-min-title">店员：<?=$clerk->name?></div>
        </div>
        <div class='demos-content-padded'>


            <?php if($right){?>

                <a id="submit" href="javascript:;" class="weui-btn weui-btn_primary">打印</a>

            <?php }else{?>

                <div class="icon-box" style="text-align: center">
                    <i class="weui-icon-warn weui-icon_msg"></i>
                    <div class="icon-box__ctn">
                        <p class="icon-box__desc">未绑定门店或者没有打印点餐码的权限</p>
                    </div>
                </div>

            <?php }?>
        </div>
    </div>

</div>
</body>
<script src="/assets/jquery.js"></script>
<script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
<script>
    $(function () {
        $("#submit").click(function () {

            $.confirm("确认打印吗？",function(){
                $.ajax({
                    url: "<?=\yii\helpers\Url::toRoute(['clerk/printing','token'=>$this->params['token']])?>",
                    type:"post",
                    data:{

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
                        if(data.success){
                            $.alert('打印成功！');
                        }else{
                            if(data.msg){
                                $.alert(data.msg);
                            }else{
                                $.alert('打印失败');
                            }
                        }
                    }
                });
            })

        })
    })
</script>
</html>
