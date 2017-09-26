<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "//cdn.bootcss.com/weui/1.1.1/style/weui.min.css",
        "//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css"
    ];
    public $js = [
        "//cdn.bootcss.com/jquery/1.11.0/jquery.min.js",
        "//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"
    ];
    public $depends = [
    ];
}
