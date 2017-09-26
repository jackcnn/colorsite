<?php
/**
 * Date: 2016/8/22
 * Time: 12:01
 * 路由规则填写
 */
$rules= [
//    "<module:(payments|fw7)>/<controller:\w+>-<action:\w+>" => '<module>/<controller>/<action>',
//    "<controller:\w+>/<id:\d+><action:\w+>" => '<controller>/<action>',
    ['class' => 'frontend\config\Route'],
];
return $rules;