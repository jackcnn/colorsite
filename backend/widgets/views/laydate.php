<?php
/**
 * Date: 2017/9/6 0006
 * Time: 10:47
 */
use yii\helpers\Html;
$id = Html::getInputId($model,$attribute);
$value = Html::getAttributeValue($model,$attribute);
switch($options['type']){
    case 'date':
        $value = date('Y-m-d',$value);break;
    case 'time':
        $value = date('H:i:s',$value);break;
    case 'datetime':
        $value = date('Y-m-d H:i:s',$value);break;
}

$opts['elem']='#'.$id;
$config = json_encode(array_merge($opts,$options));

?>
<div class="layui-form-item">
    <?= Html::activeLabel($model,$attribute,['class'=>'layui-form-label','label'=>$label]) ?>
    <div class="layui-input-inline">
        <input type="text" value="<?= $value?>" name="<?= Html::getInputName($model,$attribute)?>" id="<?= $id?>" lay-verify="date" placeholder="" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux"><?=$tips?></div>
</div>
<?php
$js = <<<JS
layui.use('laydate', function(){
    var laydate = layui.laydate;
    laydate.render({$config});
});
JS;
$this->registerJS($js);
?>
