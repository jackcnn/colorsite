<?php
/**
 * Date: 2017/9/6 0006
 * Time: 10:47
 */
namespace backend\widgets;

use yii\base\Widget;

class Laydate extends Widget
{
    public $model;
    public $attribute;
    public $options=[];
    public $label='';
    public $tips ='';

    public function init()
    {
        parent::init();
    }
    public function run()
    {
        return $this->render('laydate',[
            'model'=>$this->model,
            'attribute'=>$this->attribute,
            'options'=>array_merge($this->options,['type'=>'date']),
            'label'=>$this->label?$this->label:$this->attribute,
            'tips'=>$this->tips
        ]);
    }
}