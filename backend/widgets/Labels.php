<?php
/**
 * Date: 2017/9/20 0020
 * Time: 22:40
 * jquery labels
 */
namespace backend\widgets;

use yii\base\Widget;

class Labels extends Widget
{
    public $model;
    public $attribute;
    public $options=[];
    public $defaults=[
        '不要葱','不要香菜','少油','不辣','辣','加辣'
    ];//可供选择的标签
    public $label='';
    public $tips ='';

    public function init()
    {
        parent::init();
    }
    public function run()
    {
        return $this->render('labels',[
            'model'=>$this->model,
            'attribute'=>$this->attribute,
            'options'=>$this->options,
            'label'=>$this->label?$this->label:$this->attribute,
            'tips'=>$this->tips,
            'defaults'=>$this->defaults
        ]);
    }
}