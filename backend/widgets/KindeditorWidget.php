<?php
/**
 * Date: 2016/5/25
 * Time: 15:58
 */
namespace backend\widgets;

use yii\base\Widget;

class KindeditorWidget extends Widget
{
    public $model;
    public $attribute;//以上两个参数是为了在activefield中可以使用widget方法加的，不要删除
    public $label = '文本框';

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('kindeditor',[
            'model'=>$this->model,
            'attribute'=>$this->attribute,
            'label'=>$this->label
        ]);
    }
}