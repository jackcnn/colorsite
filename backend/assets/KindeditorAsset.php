<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/25
 * Time: 16:13
 */
namespace backend\assets;


use yii\web\AssetBundle;
class KindeditorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/kindeditor/themes/default/default.css'
    ];
    public $js = [
        'vendor/kindeditor/kindeditor-all-min.js',
    ];

    public $jsOptions=[
        'position' => \yii\web\View::POS_HEAD,
    ];

    public $depends = [

    ];
}