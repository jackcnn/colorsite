<?php
/**
 * Date: 2017/9/20 0020
 * Time: 18:26
 */
namespace backend\assets;

use yii\web\AssetBundle;

class TagEditorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/tageditor/jquery.tag-editor.css',
    ];
    public $js = [
        'vendor/tageditor/jquery.caret.min.js',
        'vendor/tageditor/jquery.tag-editor.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}