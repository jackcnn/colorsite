<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class IndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/assets/materialize/css/materialize.min.css',
        '/assets/materialize/css/style.css'
    ];
    public $js = [
        '/assets/materialize/js/materialize.min.js',
        '/assets/materialize/js/init.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
