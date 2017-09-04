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
        <ul class="layui-nav layui-nav-tree" style="display: none;">
            <li class="layui-nav-item">
                <a class="" href="javascript:;">所有商品</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;">列表一</a></dd>
                    <dd><a href="javascript:;">列表二</a></dd>
                    <dd><a href="javascript:;">列表三</a></dd>
                    <dd><a href="">超链接</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">解决方案</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;">列表一</a></dd>
                    <dd><a href="javascript:;">列表二</a></dd>
                    <dd><a href="">超链接</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="">云市场</a></li>
            <li class="layui-nav-item"><a href="">发布商品</a></li>
        </ul>

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
