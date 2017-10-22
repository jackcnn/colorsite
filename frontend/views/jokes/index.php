<?php
/**
 * Time: 11:09
 */
?>
<html>
<head>
    <meta charset="utf-8">
    <title>绅士笑话</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="/assets/reset.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
    <style>
        .weui-media-box__desc{
            display: block;
            font-size: 16px;
            line-height:1.3;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="weui-panel weui-panel_access">
        <div class="weui-panel__hd">绅士笑话</div>
        <div id="content" class="weui-panel__bd">

        </div>

        <div id="loading" style="display: block;" class="weui-loadmore">
            <i class="weui-loading"></i>
            <span class="weui-loadmore__tips">正在加载</span>
        </div>

        <div id="getmore" style="display: none;" class="weui-panel__ft">
            <a href="javascript:void(0);" class="weui-cell weui-cell_access weui-cell_link">
                <div class="weui-cell__bd">查看更多</div>
                <span class="weui-cell__ft"></span>
            </a>
        </div>
    </div>
    </div>
    </div>
</div>

<div style="display: none;">

    <div class="weui-media-box weui-media-box_text">
        <h4 class="weui-media-box__title">标题一</h4>
        <p class="weui-media-box__desc">由各种物质组成的巨型球状天体，叫做星球。星球有一定的形状，有自己的运行轨道。</p>
    </div>
    <div class="weui-media-box weui-media-box_text">
        <h4 class="weui-media-box__title">标题二</h4>
        <p class="weui-media-box__desc">由各种物质组成的巨型球状天体，叫做星球。星球有一定的形状，有自己的运行轨道。</p>
    </div>


</div>




</body>
<script src="/assets/jquery.js"></script>
<script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
<script>
$(function () {


getData();

$("#getmore").click(function () {
    getData();
})

function getData()
{
    $.ajax({
        url: "<?=\yii\helpers\Url::toRoute(['jokes/getdata'])?>",
        type:"get",
        dataType:"json",
        beforeSend:function(){
            $("#getmore").hide();
            $("#loading").show();
        },
        complete:function(){
            $("#getmore").show();
            $("#loading").hide();
        },
        error:function (XMLHttpRequest, textStatus, errorThrown){
            alert("网络错误,请重试...");
        },
        success: function(data){

            var html = "";
            $.each(data,function(n,v){
                html += "<div class=\"weui-media-box weui-media-box_text\">\n" +
                    "                <h4 class=\"weui-media-box__title\">"+v.title+"</h4>\n" +
                    "                <div class=\"weui-media-box__desc\">"+v.desc+"</div>\n" +
                    "            </div>"
            })

            $("#content").append(html);


        }
    });



}
})
</script>
</html>



