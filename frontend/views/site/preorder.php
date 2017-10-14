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
    <script src="/assets/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/reset.css">
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
                <div class="lister">
                    <div class="mark-container">
                        <textarea class="mark" name="mark" placeholder="请输入备注内容（可不填，最多150字）"></textarea>
                    </div>
                </div>
                <div class="lister">
                    <a class="re_pick" href="<?=\yii\helpers\Url::to(['site/resetorder','store_id'=>$store['id'],'token'=>$this->params['token'],'sn'=>\Yii::$app->request->get("sn")])?>">我不订了</a>
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
        if(confirm('确认删除吗？')){
            $(this).parent().remove();
        }

        if($(".remove").length < 1){
            $("#submit").html('我不订了');
        }


    })

    $("#submit").click(function () {
        if(confirm('确认提交吗？')){
            $("#form").submit();
        }
    })
})    
</script>
</html>



