<?php
/**
 * Date: 2017/9/5 0005
 * Time: 15:13
 */
namespace backend\widgets;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class LayuiForm extends Widget
{
    public $action = '';
    public $method = 'post';
    public $options = [];

    public function init()
    {
        parent::init();
        ob_start();
        ob_implicit_flush(false);
    }

    public function run()
    {
        $content = ob_get_clean();
        $options = ArrayHelper::merge($this->options,['class'=>'layui-form']);
        echo Html::beginForm($this->action, $this->method, $options);
        echo $content;
        echo Html::endForm();
    }

    public function field($model, $attribute, $options = [])
    {
        $config['class'] = "\backend\widgets\LayuiField";
        return \Yii::createObject(ArrayHelper::merge($config, $options, [
            'model' => $model,
            'attribute' => $attribute,
            'form' => $this,
        ]));
    }

}