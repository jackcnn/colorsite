<?php
/**
 * Date: 2017/9/27 0027
 * Time: 09:44
 */

?>
<style>
.title{
    display: block;
    width: 100%;
    line-height: 45px;
    text-align: center;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    padding:15px;
}
.list-container{
    display: block;
    width:100%;
}
.image{
    display: block;
    width:94%;
    margin: 15px 3%;
}
</style>
<div class="title"><?=$data['now']->title?></div>

<div class="list-container">

    <?php foreach($list as $key=>$value){?>

        <img class="image" src="<?=$value['path']?>" />

    <?php }?>

</div>
