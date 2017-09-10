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

class LayField extends Component
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

    public function lyradioList($list,$label='',$tips='')
    {
        if(!is_array($list)){
            throw new InvalidParamException('need array data');
        }
        $label=$label?$label:$this->attribute;
        $labeltext = Html::activeLabel($this->model,$this->attribute,['class'=>'layui-form-label','label'=>$label]);
        $html='<div class="layui-form-item">'.$labeltext.'<div class="layui-input-inline">';
        foreach($list as $key=>$value){
            $check_value = Html::getAttributeValue($this->model,$this->attribute);
            if("$check_value" === "{$key}"){
                $checked = "checked" ;
            }else{
                $checked = "" ;
            }
            $html.='<input type="radio" class="'. Html::getInputId($this->model,$this->attribute).'" lay-filter="'.Html::getInputId($this->model,$this->attribute).'" name="'.Html::getInputName($this->model,$this->attribute).'" value="'.$key.'" title="'.$value.'" '.$checked.'>';
        }
        $html.='</div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
    }

    /*
     * 使用json_encode 保存选项
     * */
    public function lycheckboxList($list,$label='',$tips='')
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
            $html.='<input type="checkbox" class="'. Html::getInputId($this->model,$this->attribute).'" lay-filter="'.Html::getInputId($this->model,$this->attribute).'" lay-skin="primary" name="'.Html::getInputName($this->model,$this->attribute).'[]" value="'.$key.'" title="'.$value.'" '.$checked.'>';
        }
        $html.='</div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
    }

    public function lyswitch($text='ON|OFF',$label='',$tips='')
    {
        $label=$label?$label:$this->attribute;
        $labeltext = Html::activeLabel($this->model,$this->attribute,['class'=>'layui-form-label','label'=>$label]);
        $html='<div class="layui-form-item">'.$labeltext.'<div class="layui-input-inline">';
        $check_value = Html::getAttributeValue($this->model,$this->attribute);
        if("$check_value" === "1"){
            $checked = "checked" ;
        }else{
            $checked = "" ;
        }
        $html.='<input type="checkbox" class="'. Html::getInputId($this->model,$this->attribute).'" lay-filter="'.Html::getInputId($this->model,$this->attribute).'" lay-skin="switch" lay-text="'.$text.'" name="'.Html::getInputName($this->model,$this->attribute).'" value="1" '.$checked.'>';
        $html.='</div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
    }

    public function lyselectList($list,$label='',$tips='',$placehold='请选择')
    {
        if(!is_array($list)){
            throw new InvalidParamException('need array data');
        }
        $label=$label?$label:$this->attribute;
        $labeltext = Html::activeLabel($this->model,$this->attribute,['class'=>'layui-form-label','label'=>$label]);
        $html='<div class="layui-form-item">'.$labeltext.'<div class="layui-input-inline">';
        $html.='<select id="'. Html::getInputId($this->model,$this->attribute).'"  name="'.Html::getInputName($this->model,$this->attribute).'" lay-filter="'.Html::getInputId($this->model,$this->attribute).'" lay-verify="required">';
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
        $html.='</select></div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
    }
    public function lytextArea($label='',$placeholder='',$tips='')
    {
        $labeltext=$label?$label:$this->attribute;
        $label = Html::activeLabel($this->model,$this->attribute,['class'=>'layui-form-label','label'=>$labeltext]);
        $html='<div class="layui-form-item">'.$label.'<div class="layui-input-inline">';
        $html.='<textarea id="'. Html::getInputId($this->model,$this->attribute).'"  name="'.Html::getInputName($this->model,$this->attribute).'" placeholder="'.$placeholder.'" class="layui-textarea">'.Html::getAttributeValue($this->model,$this->attribute).'</textarea>';
        $tips = $tips?$tips:'';
        $html.='</div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
    }

    public function lyshow()
    {

    }

    //$filter 事件选择器 form.on('submit(form)')
    public function lybuttons($buttons=['submit','reset','back'],$filter='form')
    {
        $html = '<div class="layui-form-item"><div class="layui-input-block">';
        if(in_array('submit',$buttons)){
            $html.= '<button id="'.$filter.'_submitBtn" class="layui-btn" lay-submit lay-filter="'.$filter.'">立即提交</button>';
        }
        if(in_array('reset',$buttons)){
            $html.= '<button type="reset" class="layui-btn layui-btn-danger">重置</button>';
        }
        if(in_array('back',$buttons)){
            $html.= '<a href="javascript:history.back();" class="layui-btn layui-btn-warm">返回</a>';
        }

        if(in_array('login',$buttons)){
            $html.= '<button id="'.$filter.'_submitBtn" class="layui-btn" lay-submit lay-filter="'.$filter.'">登录</button>';
        }
        if(in_array('register',$buttons)){
            $html.= '<a href="'.\yii\helpers\Url::to(['/site/register']).'" class="layui-btn layui-btn-normal">注册</a>';
        }

        $html.= '</div></div>';
        return $html;
    }

    public function lyfile($label='',$tips)
    {
        $labeltext=$label?$label:$this->attribute;
        $label = Html::activeLabel($this->model,$this->attribute,['class'=>'layui-form-label','label'=>$labeltext]);
        $id = Html::getInputId($this->model,$this->attribute);
        $js = 'onchange="document.getElementById(\''.$id.'span\').innerText=this.value"';
        $html='<div class="layui-form-item">'.$label.'<div class="layui-input-inline">';
        $html.='<div class="layui-btn" style="position: relative;"><i class="layui-icon">&#xe67c;</i><span style="display: inline-block;max-width: 200px;" id="'.$id.'span">请选择文件</span>';
        $html.='<input type="file" '.$js.' id="'. $id .'"  name="'.Html::getInputName($this->model,$this->attribute).'" style="position: absolute;display: block;width: 100%;height: 100%;left: 0px;top: 0px;opacity: 0;">';
        $html.='</div>';
        $value=Html::getAttributeValue($this->model,$this->attribute);
        if($value){//这里需要配合admin/vendor/layui/layuse.js里的弹框
            $html.='<div class="layui-btn display-images" data-src="'.$value.'"><i class="layui-icon">&#xe64a;</i><span>预览</span></div>';
        }
        $tips = $tips?$tips:'';
        $html.='</div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
    }

    public function lylink($text,$link='javascript:;',$label='')
    {
        $html ='<div class="layui-form-item"><label class="layui-form-label">'.$label.'</label><div class="layui-input-inline">';
        $options['style']='float:right;';
        $html .= Html::a($text,$link,$options);
        $html.='</div></div>';
        return $html;
    }

    public function widget($class, $config = [])
    {
        $config['model'] = $this->model;
        $config['attribute'] = $this->attribute;
        $config['view'] = $this->form->getView();
        return $class::widget($config);
    }

}