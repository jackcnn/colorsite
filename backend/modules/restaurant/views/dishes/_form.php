<?php

use yii\helpers\Html;
use backend\widgets\LayForm;

$speclist = json_decode($model->spec,1);

?>
<style>
    .inline-boxer{
        height:40px;line-height: 40px;}
</style>
<div class="dishes-form layform-block">

    <?php $form = LayForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'cateid')->lyselectList($category) ?>

    <?= $form->field($model, 'name')->lytextInput() ?>

    <?= $form->field($model, 'desc')->lytextArea() ?>

    <?= $form->field($model, 'price')->lytextInput(['label'=>'价格(元)']) ?>

    <?= $form->field($model, 'stock')->lytextInput() ?>

    <?= $form->field($model, 'multi')->lyselectList($spec['data'],['lay-verify' => "",'tips'=>'(开启多规格后，单独填写的价格和每日库存将失效)']) ?>

    <div id="spec_box">

        <?php if(is_array($speclist) && count($speclist)){foreach($speclist as $key=>$value){?>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-inline inline-boxer" style="width: 50px;font-weight: bolder;">
                        <?=$value['name']?>：
                    </div>
                    <div class="layui-input-inline inline-boxer" style="width: 60px;">
                        价格(元)
                    </div>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="hidden" name="spec_name[<?=$key?>]" value="<?=$value['name']?>">
                        <input type="text" name="spec_price[<?=$key?>]" value="<?=$value['price']/100?>" class="layui-input">
                    </div>
                    <div class="layui-input-inline inline-boxer" style="width: 60px;">
                        每日库存
                    </div>
                    <div class="layui-input-inline inline-boxer" style="width: 100px;">
                        <input type="text" name="spec_stock[<?=$key?>]" value="<?=$value['stock']?>" class="layui-input">
                    </div>
                </div>
            </div>


        <?php }}?>







    </div>

    <?= $form->field($model, 'recommend')->lyswitch([],'是|否') ?>

    <?= $form->field($model, 'onsale')->lyswitch([],'是|否') ?>

    <?= $form->field($model, 'cover')->lyfile() ?>

    <?= $form->field($model, 'sort')->lytextInput() ?>

    <?= $form->field($model, 'unit')->lytextInput() ?>

    <?= $form->field($model, 'labes')->widget(backend\widgets\Labels::className(),['label'=>'标签']) ?>



    <?= $form->field($model, 'created_at')->lyhidden() ?>

    <?= $form->field($model, 'updated_at')->lyhidden() ?>
    <?= $form->field($model, 'ownerid')->lyhidden() ?>

    <?= $form->field($model, 'token')->lyhidden() ?>

    <?= $form->field($model, '')->lybuttons() ?>

    <?php LayForm::end(); ?>

</div>


<?php foreach($spec['ndata'] as $key=>$value){?>

    <script type="text/html" id="spec<?=$key?>">

        <?php foreach($value as $k=>$v){?>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-inline inline-boxer" style="width: 50px;font-weight: bolder;">
                        <?=$v?>：
                    </div>
                    <div class="layui-input-inline inline-boxer" style="width: 60px;">
                        价格(元)
                    </div>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="hidden" name="spec_name[<?=$k?>]" value="<?=$v?>">
                        <input type="text" name="spec_price[<?=$k?>]" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline inline-boxer" style="width: 60px;">
                        每日库存
                    </div>
                    <div class="layui-input-inline inline-boxer" style="width: 100px;">
                        <input type="text" name="spec_stock[<?=$k?>]" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>


        <?php }?>

    </script>

<?php }?>



<?php

$js = <<<JS


layui.use('form', function(){
  var form = layui.form;
  
  form.on('select(dishes-multi)', function(data){
        console.log(data.value); //得到被选中的值
        
        if(data.value > 0 ){
            var html = jQuery("#spec"+data.value).html();
            jQuery("#spec_box").html(html);
        }else{
            jQuery("#spec_box").html('');
        }
        
        
  }); 
  
  
});

JS;

$this->registerJS($js);

?>