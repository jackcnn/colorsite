<?php
/**
 * Created by PhpStorm.
 * User: lurongze
 * Date: 2017/10/26
 * Time: 10:23
 */
use \yii\helpers\ColorHelper;

$list0 = [
    '/uploads/00001/taobao/1zhangguishuo.jpg',
    '/uploads/00001/taobao/2muhouhuaxu.jpg',
    '/uploads/00001/taobao/3motexinxi.jpg',
    '/uploads/00001/taobao/4chimabiao.jpg',
    '/uploads/00001/taobao/5moteshifang.jpg',
    '/uploads/00001/taobao/6pingpushipai.jpg',
    '/uploads/00001/taobao/7xijietexie.jpg',
    '/uploads/00001/taobao/logo.jpg',

];

?>
<div clas="ee"></div>
<div class="left-container">


</div>
<div class="right-container">
    <a id="add-img" class="layui-btn">添加图片</a>
    <a id="add-def" class="layui-btn">添加默认图片</a>
    <ul>
        <li>1.一张最好看的图片</li>
        <li>2.掌柜说图片</li>
        <li>3.幕后花絮图片</li>
        <li>4.其他颜色一张最好看的图片</li>
        <li>5.模特信息</li>
        <li>6.尺码表</li>
        <li>7.模特示范标题图片</li>
        <li>8.同种颜色正反侧等图片一张</li>
        <li>9.LOGO图片</li>
        <li>10.重复8，9至所有颜色衣服都展示完</li>
        <li>11.平铺实拍标题图和平铺实拍图片</li>
        <li>12.细节特写标题图</li>
        <li>13.一张细节图，一张logo。细节图多包括衣领，标签，正方面图案</li>
    </ul>
</div>



<div id="list-0" class="list">
    <?php foreach($list as $key=>$value){?>
        <div class="lister" data-path="<?=$value['path']?>" data-key="ss<?=$key?>">
            <img src="<?=$value['path']?>" />
        </div>
    <?php }?>
</div>




<div id="list-1" class="list">
    <?php foreach($list0 as $key=>$value){?>
        <div class="lister" style="width: 90%;border: 1px solid #0a0a0a;" data-path="<?=$value?>">
            <img src="<?=$value?>" />
        </div>
    <?php }?>
</div>





<?php
$js = <<<JS

    $("#add-img").click(function(){
        $("#list-1").hide();
        $("#list-0").toggle();
    })
    
    
    $(".lister").click(function(){
        
        var path = $(this).data("path");
        var key = $(this).data('key');
        
        if($(this).hasClass('sel')){
            
        }else{
            var html='<div id="'+key+'" class="imgs"><img src="'+path+'"/><ul>' +
             
              '<li class="deltp">top:0px</li><li class="cuttp">top:35px</li><li class="retp">top:75px</li>' +
               '<li class="delbp">bottom:0px</li><li class="cutbp">bottom:35px</li><li class="rebp">bottom:75px</li>' +
              '<li class="delthis" style="background:#FF0000">删除</li>' +
                '</ul></div>';
        
            $(".left-container").append(html);
            
            // $('.layui-body').animate({  
            //         scrollTop: 200000
            // }, 3000);  
            
        }
        
    })
    
    
    $("#add-def").click(function(){
        $("#list-0").hide();
        $("#list-1").toggle();
    })
    
    
    $(document).on('click',".left-container .imgs",function(){
        $(this).find("ul").toggle();
    })
    
    $(document).on('click',".delthis",function(){
        $(this).parent().parent().remove();
    })

    $(document).on('click',".deltp",function(){
        $(this).parent().parent().css({'margin-top':'0px'});
    })
    
    $(document).on('click',".retp",function(){
        $(this).parent().parent().css({'margin-top':'75px'});
    })
    
    $(document).on('click',".delbp",function(){
        $(this).parent().parent().css({'margin-bottom':'0px'});
    })
    
     $(document).on('click',".cuttp",function(){
        $(this).parent().parent().css({'margin-top':'35px'});
    })
    
    $(document).on('click',".cutbp",function(){
        $(this).parent().parent().css({'margin-bottom':'35px'});
    })
    
    
    $(document).on('click',".rebp",function(){
        $(this).parent().parent().css({'margin-bottom':'75px'});
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
        padding:25px 0px;
        background-color: #FFFFFF;
        overflow: hidden;

    }
    .left-container .imgs:first-child{
        margin-top:0px;
    }
    .left-container .imgs{
        display: inline-block;
        width:700px;
        margin: 75px 25px;
        position: relative;
    }
    .imgs img{
        display: block;
        width:100%;
    }
    .imgs ul{
        display: none;
        position: absolute;
        top: 0px;
        right:0px;
        padding:5px;
        background: rgba(0,0,0,.7);
        color: #FFFFFF;
        width:270px;
    }
    .imgs ul li{
        display: inline-block;
        width:80px;
        margin:5px 5px;
        height:45px;
        line-height:45px;
        text-align: center;
        background: #20a0ff;
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
