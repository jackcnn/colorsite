<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules'=>[
        'weixin' => [
            'class' => 'common\modules\weixin\WeixinModule',
        ],
        'payments' => [
            'class' => 'common\modules\payments\PaymentsModules',
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'dateFormat' => 'yyyy-MM-dd',
            'datetimeFormat' =>'yyyy-MM-dd H:i:s',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'CNY',
        ],
    ],
    'language' =>'zh-CN',//中文提示
    'timeZone' => 'Asia/Shanghai',
];
