<?php
/**
 * Date: 2017/9/18 0018
 * Time: 15:48
 */
use backend\assets\TagEditorAsset;


TagEditorAsset::register($this);


?>

<a class="layui-btn" href="<?=\yii\helpers\Url::to(['/site/logout'])?>">退出登录</a>

<a class="layui-btn" id="dd" href="#">退出登录</a>

<input type="text" id="text" />

<h1 class="layform-h1">test</h1>


<?php

$js = <<<JS

jQuery(function () {
        $('#text').tagEditor({
            initialTags: ['tag1', 'tag2', 'tag3'],
            maxTags:5
        });
        
        $("#dd").click(function() {
          $('#text').tagEditor('addTag', 'example');
        })
    })


JS;

$this->registerJS($js);

?>

