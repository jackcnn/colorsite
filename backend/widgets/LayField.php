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
        $opts['class']='layui-input ';
        if(isset($options['disabled']) && $options['disabled']){
            $opts['class']='layui-input layui-disabled';
        }
        $opts['autocomplete']='off';
        $opts['placeholder'] = isset($options['placeholder'])?$options['placeholder']:'';
        if(isset($options['lay-verify'])){
            $opt['lay-verify'] = $options['lay-verify'];
        }
        $loptions['class'] = 'layui-form-label';
        if(isset($options['label'])){
            $loptions['label']=$options['label'];
        }
        $label = Html::activeLabel($this->model,$this->attribute,$loptions);

        $html='<div class="layui-form-item">'.$label.'<div class="layui-input-inline">';
        $options = array_merge($opts, $options);
        $html.=Html::activeTextInput($this->model, $this->attribute, $options);
        $tips = isset($options['tips'])?$options['tips']:'';
        $html.='</div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
    }

    public function lyhidden($options = [])
    {
        $opts['class']='layui-input ';
        if(isset($options['disabled']) && $options['disabled']){
            $opts['class']='layui-input layui-disabled';
        }
        $opts['autocomplete']='off';
        $opts['placeholder'] = isset($options['placeholder'])?$options['placeholder']:'';
        if(isset($options['lay-verify'])){
            $opt['lay-verify'] = $options['lay-verify'];
        }
        $loptions['class'] = 'layui-form-label';
        if(isset($options['label'])){
            $loptions['label']=$options['label'];
        }
        $label = Html::activeLabel($this->model,$this->attribute,$loptions);
        $html='<div style="display:none;" class="layui-form-item">'.$label.'<div class="layui-input-inline">';
        $options = array_merge($opts, $options);
        $html.=Html::activeHiddenInput($this->model, $this->attribute, $options);
        $tips = isset($options['tips'])?$options['tips']:'';
        $html.='</div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
    }

    public function lypasswordInput($options = [])
    {
        $opts['class']='layui-input';
        if(isset($options['disabled']) && $options['disabled']){
            $opts['class']='layui-input layui-disabled';
        }
        $opts['autocomplete']='off';
        $opts['placeholder'] = isset($options['placeholder'])?$options['placeholder']:'';
        if(isset($options['lay-verify'])){
            $opt['lay-verify'] = $options['lay-verify'];
        }

        $loptions['class'] = 'layui-form-label';
        if(isset($options['label'])){
            $loptions['label']=$options['label'];
        }
        $label = Html::activeLabel($this->model,$this->attribute,$loptions);

        $html='<div class="layui-form-item">'.$label.'<div class="layui-input-inline">';
        $options = array_merge($opts, $options);
        $html.=Html::activePasswordInput($this->model, $this->attribute, $options);
        $tips = isset($options['tips'])?$options['tips']:'';
        $html.='</div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
    }

    public function lyradioList($list,$options=[])
    {
        if(!is_array($list)){
            throw new InvalidParamException('need array data');
        }
        $loptions['class'] = 'layui-form-label';
        if(isset($options['label'])){
            $loptions['label']=$options['label'];
        }
        $label = Html::activeLabel($this->model,$this->attribute,$loptions);

        $html='<div class="layui-form-item">'.$label.'<div class="layui-input-inline">';
        foreach($list as $key=>$value){
            $opts = [];
            $opts['class']=Html::getInputId($this->model,$this->attribute);
            $opts['lay-filter']=Html::getInputId($this->model,$this->attribute);
            $opts['value'] = $key;
            $opts['title'] = $value;
            $rdoptions = array_merge($opts,$options);
            $rdoptions['label'] = false;//不要生成label
            $html.= Html::activeRadio($this->model,$this->attribute,$rdoptions);
        }
        $tips = isset($options['tips'])?$options['tips']:'';
        $html.='</div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
    }

    /*
     * 使用json_encode 保存选项
     * */
    public function lycheckboxList($list,$options=[])
    {
        if(!is_array($list)){
            throw new InvalidParamException('need array data');
        }

        $loptions['class'] = 'layui-form-label';
        if(isset($options['label'])){
            $loptions['label']=$options['label'];
        }
        $label = Html::activeLabel($this->model,$this->attribute,$loptions);

        $html='<div class="layui-form-item">'.$label.'<div class="layui-input-block">';
        foreach($list as $key=>$value){
            $opts = [];
            $opts['class']=Html::getInputId($this->model,$this->attribute);
            $opts['lay-filter']=Html::getInputId($this->model,$this->attribute);
            $opts['lay-skin'] ='primary';
            $opts['value'] = $key;
            $opts['title'] = $value;
            $ckoptions = ArrayHelper::merge($opts,$options);
            $ckoptions['label'] = false;//不要生成label
            $ckoptions['name'] = Html::getInputName($this->model,$this->attribute)."[".$key."]";
            $html.= Html::activeCheckbox($this->model,$this->attribute,$ckoptions);
        }
        $tips = isset($options['tips'])?$options['tips']:'';
        $html.='</div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
    }

    public function lyswitch($options=[],$text='ON|OFF')
    {
        $loptions['class'] = 'layui-form-label';
        if(isset($options['label'])){
            $loptions['label']=$options['label'];
        }
        $label = Html::activeLabel($this->model,$this->attribute,$loptions);

        $html='<div class="layui-form-item">'.$label.'<div class="layui-input-inline">';
        $opts['class'] = Html::getInputId($this->model,$this->attribute);
        $opts['lay-filter'] = Html::getInputId($this->model,$this->attribute);
        $opts['lay-skin'] = "switch";
        $opts['lay-text'] = $text;
        $opts['value'] = 1;
        $ckoptions = array_merge($opts,$options);
        $ckoptions['label'] = false;
        $html.= Html::activeCheckbox($this->model,$this->attribute,$ckoptions);
        $tips = isset($options['tips'])?$options['tips']:'';
        $html.='</div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
    }

    public function lyselectList($list,$options=[])
    {
        if(!is_array($list)){
            throw new InvalidParamException('need array data');
        }
        $loptions['class'] = 'layui-form-label';
        if(isset($options['label'])){
            $loptions['label']=$options['label'];
        }
        $label = Html::activeLabel($this->model,$this->attribute,$loptions);
        $html='<div class="layui-form-item">'.$label.'<div class="layui-input-inline">';
        $opts['lay-filter'] = Html::getInputId($this->model,$this->attribute);
        $opts['lay-verify'] = "required";
        $dpoptions = array_merge($opts,$options);
        $dpoptions['label'] = false;
        //$list = array_merge([''=>'请选择'],$list);
        $list = ArrayHelper::merge([''=>'请选择'],$list);
        $html.= Html::activeDropDownList($this->model,$this->attribute,$list,$dpoptions);
        $tips = isset($options['tips'])?$options['tips']:'';
        $html.='</div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
    }
    public function lytextArea($options = [])
    {
        $loptions['class'] = 'layui-form-label';
        if(isset($options['label'])){
            $loptions['label']=$options['label'];
        }
        $label = Html::activeLabel($this->model,$this->attribute,$loptions);
        $html='<div class="layui-form-item">'.$label.'<div class="layui-input-inline">';
        //$html.='<textarea id="'. Html::getInputId($this->model,$this->attribute).'"  name="'.Html::getInputName($this->model,$this->attribute).'" placeholder="'.$placeholder.'" class="layui-textarea">'.Html::getAttributeValue($this->model,$this->attribute).'</textarea>';
        $opts['id'] = Html::getInputId($this->model,$this->attribute);
        $opts['class'] = 'layui-textarea';
        if(isset($options['disabled']) && $options['disabled']){
            $opts['class']='layui-textarea layui-disabled';
        }
        $taoptions = array_merge($opts,$options);
        $taoptions['label'] = false;
        $html.= Html::activeTextarea($this->model,$this->attribute,$taoptions);
        $tips = isset($options['tips'])?$options['tips']:'';
        $html.='</div><div class="layui-form-mid layui-word-aux">'.$tips.'</div></div>';
        return $html;
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

    public function lyfile($label='',$tips='',$file = false)
    {
        $loptions['class'] = 'layui-form-label';
        if($label){
            $loptions['label']=$label;
        }
        $label = Html::activeLabel($this->model,$this->attribute,$loptions);

        $id = Html::getInputId($this->model,$this->attribute);
        $js = 'onchange="document.getElementById(\''.$id.'span\').innerText=this.value"';
        $html='<div class="layui-form-item">'.$label.'<div class="layui-input-inline">';
        $html.='<div class="layui-btn" style="position: relative;"><i class="layui-icon">&#xe67c;</i><span style="display: inline-block;max-width: 200px;" id="'.$id.'span">请选择文件</span>';
        $html.='<input type="file" '.$js.' id="'. $id .'"  name="'.Html::getInputName($this->model,$this->attribute).'" style="position: absolute;display: block;width: 100%;height: 100%;left: 0px;top: 0px;opacity: 0;">';
        $html.='</div>';
        $value=Html::getAttributeValue($this->model,$this->attribute);
        if($value){//这里需要配合admin/vendor/layui/layuse.js里的弹框
            if($file){
                $tips = "($value)";
            }else{//图片上传的显示预览按钮
                $html.='<div class="layui-btn display-images" data-src="'.$value.'"><i class="layui-icon">&#xe64a;</i><span>预览</span></div>';
            }
        }
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