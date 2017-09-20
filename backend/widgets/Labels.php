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
            'options'=>array_merge($this->options,['type'=>'date']),
            'label'=>$this->label?$this->label:$this->attribute,
            'tips'=>$this->tips
        ]);
    }
}