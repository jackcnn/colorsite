<?php
/**
 * Date: 2017/9/6 0006
 * Time: 17:02
 */
use yii\helpers\Html;
?>
<div class="layui-tab" style="padding: 0px 15px;">
    <ul class="layui-tab-title-ss">
        <?php foreach($list as $key=>$value){?>
            <li <?php if($value[1][0] == $active){?>class="layui-this"<?php }?>><?= Html::a($value[0],$value[1])?></li>
        <?php }?>
    </ul>
</div>
