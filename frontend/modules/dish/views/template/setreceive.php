<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/25 0025
 * Time: 20:34
 */

?>
<html>
<head>
    <meta charset="utf-8">
    <title>橙蓝网络科技服务平台</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="/assets/reset.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
    <style>
        body{
            padding:90px 0px;
            box-sizing: border-box;
        }
        .demos-title{
            font-size:18px;
            color: #20A0FF;
            padding:0px 20px;
            text-align: center;
        }
        #bind{
            margin-top:50px;
            width:50%;
        }
        .chenglan-logo{
            display: block;
            width:100%;
            text-align: center;
        }
    </style>
</head>
<body ontouchstart>
<header class='demos-header'>
    <h1 class="demos-title">设置收款通知</h1>
</header>

<div class="weui-cells weui-cells_form">
    <?php foreach($list as $key=>$value){?>

        <div class="weui-cell weui-cell_switch">
            <div class="weui-cell__bd"><?=$value['storeName']?>(<?=$value['name']?>)</div>
            <div class="weui-cell__ft">
                <input class="weui-switch" type="checkbox" name="list[]"  value="<?=$value['id']?>" <?=$value['is_receive']>0?'checked':''?>>
            </div>
        </div>

    <?php }?>
</div>

<div class='demos-content-padded'>
    <a id="bind" href="javascript:;" class="weui-btn weui-btn_primary">确认修改</a>
</div>

<div class="chenglan-logo">
    <img src="/uploads/chenglanapp.jpg" />
</div>

</body>
<script src="/assets/jquery.js"></script>
<script src="https://cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>
<script src="https://cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
<script>
$(function () {
    FastClick.attach(document.body);

    $("#bind").click(function () {
        var list = new Array();
        $(".weui-switch").each(function () {

            if($(this).is(":checked")){
                list.push($(this).val()+'-1');
            }else{
                list.push($(this).val()+'-0');
            }
        })

        //console.log(list);

        $.showLoading();

        $.post(location.href,{
            openid:'<?=$res['openid']?>',
            list:list
        },function (res) {
            $.hideLoading();
            $.alert(res.msg,function () {
                return location.reload();
            });
        })

    })


})
</script>
</html>
