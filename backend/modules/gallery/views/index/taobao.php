<?php
/**
 * Created by PhpStorm.
 * User: lurongze
 * Date: 2017/10/26
 * Time: 10:23
 */
use \yii\helpers\ColorHelper;

?>
<div clas="ee"></div>
<div class="left-container">


</div>
<div class="right-container">

    <a id="add-img" class="layui-btn">添加图片</a>
    <a id="shengc" class="layui-btn">生产图片</a>
</div>



<div class="list">
    <?php foreach($list as $key=>$value){?>
        <div class="lister" data-path="<?=$value['path']?>">
            <img src="<?=$value['path']?>" />
        </div>

    <?php }?>

</div>




<?php
$js = <<<JS

    $("#add-img").click(function(){
        $(".list").toggle();
    })
    
    
    $(".lister").click(function(){
        
        var path = $(this).data("path");
        
        var html='<div class="imgs"><img src="'+path+'"/></div>';
        
        $(".left-container").append(html);
        
    })
    
    
    $("#shengc").click(function(){
                

    })


JS;

$this->registerJS($js);
?>

<style>
    body{
        background-color: #F9FAFC;
    }
    .header-actions{display: none!important;}
    .left-container{
        display: block;
        width:750px;
        padding:50px 0px;
        background-color: #FFFFFF;

    }
    .left-container .imgs{
        display: block;
        width:700px;
        margin: 10px auto;
    }
    .imgs img{
        display: block;
        width:100%;
    }
    .right-container{
        display: block;
        position: fixed;
        top:10px;
        left:780px;
    }
    .list{
        display: none;
        position: fixed;
        width:400px;
        height:80%;
        overflow: auto;
        top:50px;
        right:20px;

        background: #FFFFFF;
    }
    .lister{
        display: inline-block;
        width:30%;
        margin-left:1%;
        margin-top:15px;
    }
    .lister img{
        display: block;
        width:100%;
    }
    .layui-container{
        padding-left:0px;
    }
</style>
