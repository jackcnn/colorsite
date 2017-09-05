<?php
/**
 * Date: 2017/9/4 0004
 * Time: 11:20
 */
use yii\helpers\Html;
?>
<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <ul class="layui-nav layui-nav-tree">
            <?php foreach($list as $key=>$value){?>
                <li class="layui-nav-item">
                    <?php if(isset($value['list'])){?>
                        <li class="layui-nav-item">
                            <a href="javascript:;"><?=$value['label']?></a>
                            <dl class="layui-nav-child">
                            <?php foreach($value['list'] as $k=>$v){?>
                                <dd><a href="javascript:;"><?=$v['label']?></a></dd>
                            <?php }?>
                            </dl>
                        </li>
                    <?php }else{?>
                        <li class="layui-nav-item"><a href=""><?=$value['label']?></a></li>
                    <?php }?>
                </li>
            <?php }?>

        </ul>



    </div>
</div>
