<?php
/**
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
    <link href="/assets/preorder.css" rel="stylesheet">
</head>
<body>
<div>
    <div class="container">
        <div class="lister-container">

            <form id="form" method="post" action="<?=\yii\helpers\Url::to(['site/saveorder','store_id'=>$store->id,'token'=>$this->params['token'],'sn'=>\Yii::$app->request->get("sn")])?>">

                <div class="lister">
                    <div class="header"><?=$store->name?></div>
                    <ul class="content">
                        <?php foreach($dishes as $key=>$value){?>
                            <li class="lister-item">
                                <div class="name"><?=$value['name']?></div>
                                <div class="count">×<?=$value['order_count']?></div>
                                <div class="total">￥<?=$value['order_single_amount']/100?></div>
                                <div class="desc">
                                    <?php foreach($value['labels'] as $k=>$v){?>
                                        <span data-id="<?=$value['id']?>" class="labels"><?=$v?></span>
                                    <?php }?>
                                </div>
                                <div class="action remove">
                                    <span>删除</span>
                                </div>
                                <input type="hidden" name="count[<?=$key?>]" value="<?=$value['order_count']?>" />
                                <input type="hidden" name="ids[<?=$key?>]" value="<?=$value['id']?>" />
                                <input type="hidden" class="labels_input" name="labels[<?=$key?>]" value=""  />
                            </li>
                        <?php }?>
                    </ul>
                </div>
                <div class="lister" style="display: none;">
                    <div class="mark-container">
                        <textarea class="mark" name="mark" placeholder="请输入备注内容（可不填，最多150字）"></textarea>
                    </div>
                </div>
                <div class="lister">
                    <a id="cancle" class="re_pick" href="<?=\yii\helpers\Url::to(['site/resetorder','store_id'=>$store['id'],'token'=>$this->params['token'],'sn'=>\Yii::$app->request->get("sn")])?>">我不订了</a>
                    <a class="re_pick" style="background: #20A0FF" href="<?=\yii\helpers\Url::to(['site/index','store_id'=>$store['id'],'token'=>$this->params['token'],'sn'=>\Yii::$app->request->get("sn")])?>">我还要点餐</a>
                </div>
            </form>
        </div>
    </div>


    <div>
        <div class="shopCart">
            <div class="content">
                <div class="content-left">
                    <div class="price active">
                        ￥<?=$total/100?>
                    </div>
                    <div class="desc">
                        添加备注后提交
                    </div>
                </div>
                <div id="submit" data-total="0" class="content-right enough">我已订好</div>
            </div>
        </div>
        <div class="backdrop"></div>
    </div>
</div>
</body>
<script src="/assets/jquery.js"></script>
<script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
<script>
$(function () {
    //点击labels变色和想要的input值改变
    $(".labels").click(function () {
        var self = $(this);
        self.toggleClass("active");
        var str = "";
        self.parent().find(".labels").each(function () {
            if($(this).hasClass("active")){
                if(!str){
                    str = $(this).html();
                }else{
                    str = str + "," + $(this).html();
                }
            }
        })
        self.parent().parent().find(".labels_input").val(str);
    })

    $(".remove").click(function () {

        $.confirm("确认删除吗？", function() {
            $(this).parent().remove();
        });

        if($(".remove").length < 1){
            $("#submit").html('我不订了');
        }

    })

    $("#cancle").click(function (e) {
        e.preventDefault();
        var self = $(this);
        $.confirm("将清空您菜单，确认吗？",function () {
            return location.href = self.attr("href");
        })

    })


    $("#submit").click(function () {
        $.confirm("确认提交吗？", function() {
            $("#form").submit();
        });
    })
})    
</script>
</html>



