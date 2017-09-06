<?php
/**
 * Date: 2017/9/6 0006
 * Time: 16:58
 */
namespace backend\widgets;

use yii\base\Widget;

class LayTable extends Widget
{
    public $model;
    public $attribute;
    public $options=[];

    public function init()
    {
        parent::init();
    }
    public function run()
    {
        return $this->render('laytable',[
            'model'=>$this->model,
            'attribute'=>$this->attribute,
            'options'=>array_merge($this->options,['type'=>'date']),
        ]);
    }
}

