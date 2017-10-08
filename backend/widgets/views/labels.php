<?php
/**
 * Date: 2017/9/6 0006
 * Time: 10:47
 */
use yii\helpers\Html;
backend\assets\TagEditorAsset::register($this);
$id = Html::getInputId($model,$attribute);
$value = Html::getAttributeValue($model,$attribute);
$tags = explode(',',$value);
$tagsStr = "'".implode("','",$tags)."'";
?>
<div class="layui-form-item">
    <?= Html::activeLabel($model,$attribute,['class'=>'layui-form-label','label'=>$label]) ?>
    <div class="layui-input-inline">
        <input type="text" value="<?= $value?>" name="<?= Html::getInputName($model,$attribute)?>" id="<?= $id?>"  class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux"><?=$tips?></div>
</div>
<div class="layui-form-item">
    <?= Html::activeLabel($model,$attribute,['class'=>'layui-form-label','label'=>'(常用)']) ?>
    <div class="layui-input-inline">
        <?php foreach($defaults as $k=>$v){?>
            <span onclick="jQuery('#<?=$id?>').tagEditor('addTag', '<?=$v?>');" class="layui-btn layui-btn-small" style="margin: 5px 5px 5px 0px;"><?=$v?></span>
        <?php }?>
    </div>
    <div class="layui-form-mid layui-word-aux">点击添加，最多10个，也可写入按ENTER键添加</div>
</div>
<?php
$js = <<<JS
jQuery("#{$id}").tagEditor({
    initialTags: [{$tagsStr}],
    maxTags:10
});
JS;
$this->registerJS($js);
?>
