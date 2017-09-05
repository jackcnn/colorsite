<?php
/**
 * layui form 生成表单域
 * Date: 2017/9/5 0005
 * Time: 15:21
 */
namespace backend\widgets;
use yii\base\Component;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class LayuiField extends Component
{
    public $form;
    public $model;
    public $attribute;
    /*
     * $options = [
     * verify -- layui 的验证 required|phone|number|email
     * tips --- 辅助文字
     * ]
     * */
    public function lytextInput($options = [])
    {
        $opts['class']='layui-input';
        $opts['autocomplete']='off';
        $opts['placeholder'] = isset($options['placeholder'])?$options['placeholder']:'';
        if(isset($options['lay-verify'])){
            $opt['lay-verify'] = $options['lay-verify'];
        }
        $labeltext=isset($options['label'])?$options['label']:$this->attribute;
        $label = Html::activeLabel($this->model,$this->attribute,['class'=>'layui-form-label','label'=>$labeltext]);
        $html='<div class="layui-form-item">'.$label.'<div class="layui-input-inline">';
        $options = array_merge($opts, $options);
        $html.=Html::activeTextInput($this->model, $this->attribute, $options);
        $tips = isset($options['tips'])?$options['tips']:'';
        $html.='</div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
    }

    public function lypasswordInput($options = [])
    {
        $opts['class']='layui-input';
        $opts['autocomplete']='off';
        $opts['placeholder'] = isset($options['placeholder'])?$options['placeholder']:'';
        if(isset($options['lay-verify'])){
            $opt['lay-verify'] = $options['lay-verify'];
        }
        $labeltext=isset($options['label'])?$options['label']:$this->attribute;
        $label = Html::activeLabel($this->model,$this->attribute,['class'=>'layui-form-label','label'=>$labeltext]);
        $html='<div class="layui-form-item">'.$label.'<div class="layui-input-inline">';
        $options = array_merge($opts, $options);
        $html.=Html::activePasswordInput($this->model, $this->attribute, $options);
        $tips = isset($options['tips'])?$options['tips']:'';
        $html.='</div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
    }

    public function lyradioList($list,$label='')
    {
        if(!is_array($list)){
            throw new InvalidParamException('need array data');
        }
        $label=$label?$label:$this->attribute;
        $labeltext = Html::activeLabel($this->model,$this->attribute,['class'=>'layui-form-label','label'=>$label]);
        $html='<div class="layui-form-item">'.$labeltext.'<div class="layui-input-block">';
        foreach($list as $key=>$value){
            $check_value = Html::getAttributeValue($this->model,$this->attribute);
            if("$check_value" === "{$key}"){
                $checked = "checked" ;
            }else{
                $checked = "" ;
            }
            $html.='<input type="radio" name="'.Html::getInputName($this->model,$this->attribute).'" value="'.$key.'" title="'.$value.'" '.$checked.'>';
        }
        $html.='</div></div>';
        return $html;
    }

    /*
     * 使用json_encode 保存选项
     * */
    public function lycheckboxList($list,$label='')
    {
        if(!is_array($list)){
            throw new InvalidParamException('need array data');
        }
        $label=$label?$label:$this->attribute;
        $labeltext = Html::activeLabel($this->model,$this->attribute,['class'=>'layui-form-label','label'=>$label]);
        $html='<div class="layui-form-item">'.$labeltext.'<div class="layui-input-block">';
        foreach($list as $key=>$value){
            $check_value = Html::getAttributeValue($this->model,$this->attribute);
            if(strpos($check_value,$key)){
                $checked = "checked" ;
            }else{
                $checked = "" ;
            }
            $html.='<input type="checkbox" lay-skin="primary" name="'.Html::getInputName($this->model,$this->attribute).'[]" value="'.$key.'" title="'.$value.'" '.$checked.'>';
        }
        $html.='</div></div>';
        return $html;
    }

    public function lyswitch($text='ON|OFF',$label='')
    {
        $label=$label?$label:$this->attribute;
        $labeltext = Html::activeLabel($this->model,$this->attribute,['class'=>'layui-form-label','label'=>$label]);
        $html='<div class="layui-form-item">'.$labeltext.'<div class="layui-input-block">';
        $check_value = Html::getAttributeValue($this->model,$this->attribute);
        if("$check_value" === "1"){
            $checked = "checked" ;
        }else{
            $checked = "" ;
        }
        $html.='<input type="checkbox" lay-skin="switch" lay-text="'.$text.'" name="'.Html::getInputName($this->model,$this->attribute).'" value="1" '.$checked.'>';
        $html.='</div></div>';
        return $html;
    }

    public function lyselectList($list,$label='',$placehold='请选择')
    {
        if(!is_array($list)){
            throw new InvalidParamException('need array data');
        }
        $label=$label?$label:$this->attribute;
        $labeltext = Html::activeLabel($this->model,$this->attribute,['class'=>'layui-form-label','label'=>$label]);
        $html='<div class="layui-form-item">'.$labeltext.'<div class="layui-input-inline">';
        $html.='<select name="'.Html::getInputName($this->model,$this->attribute).'" lay-verify="required">';
        $html.='<option value="">'.$placehold.'</option>';
        foreach($list as $key=>$value){
            $selected_value = Html::getAttributeValue($this->model,$this->attribute);
            if("$selected_value" === "{$key}"){
                $selected = "selected" ;
            }else{
                $selected = "" ;
            }
            $html.='<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
        }
        $html.='</select></div></div>';
        return $html;
    }

}