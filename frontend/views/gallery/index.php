<?php
/**
 * Date: 2017/9/16 0016
 * Time: 19:44
 */

?>
<style>
.card-container{
    display: block;
    background-color: #FFFFFF;
    width:45%;
    margin:5px 2.5% 35px 2.5%;
    box-shadow: 0 2px 4px 0 rgba(0,0,0,.12),0 0 6px 0 rgba(0,0,0,.04);
    float: left;
}
.card-box{
    width:100%;
}
.card-title{
    display: block;
    width:100%;
    line-height: 45px;
    padding:5px 15px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.card-img{
    display: block;
    width:100%;
}
body{
    background-color: #eef1f6;
}
</style>

<?php foreach($gallerys as $key=>$value){?>
    <div class="card-container">
        <div class="card-box">
            <div class="card-title"><?=$value['title']?></div>
            <a href="<?=\yii\helpers\Url::to(['gallery/detail','id'=>$value['id'],'token'=>$this->params['token']])?>">
                <img class="card-img" src="<?=$value['logo']?>" />
            </a>
        </div>
    </div>
<?php }?>


<?= yii\widgets\LinkPager::widget(['pagination'=>$pagination])?>
<?= frontend\widgets\Jweixin::widget(['token'=>$this->params['token']])?>