<?php
/**
 * Date: 2017/9/6 0006
 * Time: 16:58
 * 选项卡
 */
namespace backend\widgets;

use yii\base\Widget;

class LayTabs extends Widget
{
    /*
     *$list= [
        ['用户管理',['/user/index/create','id'=>1]],
        ['权限分配',['/user/index/index','id'=>2]],
        ['商品管理',['/site/index','id'=>3]]
    ]
     * */
    public $list=[];
    public $active;
    public function init()
    {
        parent::init();
    }
    public function run()
    {
        if(!count($this->list)){
            return '';
        }

        if(!$this->active){
            $active = '/'.\Yii::$app->controller->id.'/'.\Yii::$app->controller->action->id;
            $moduel = \Yii::$app->controller->module->id;
            if($moduel != 'app-backend'){
                $active = '/'.$moduel.$active;
            }
        }else{
            $active = $this->active;
        }
        return $this->render('laytabs',[
            'list'=>$this->list,
            'active'=>$active
        ]);
    }
}

