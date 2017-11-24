<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@site', dirname(dirname(__DIR__)) . '/site');

//admin owid
defined('ADMIN_OWID') or define('ADMIN_OWID',39);

//橙蓝易点餐小程序
defined('CHENGLAN_DIANCAN_APPID') or define('CHENGLAN_DIANCAN_APPID','wxa6a74ccfdf8979b9');
defined('CHENGLAN_DIANCAN_APPSECRET') or define('CHENGLAN_DIANCAN_APPSECRET','a5167f628a170074479a174322a120d1');

//橙蓝微信公众号
defined('CHENGLAN_APPID') or define('CHENGLAN_APPID','wxb71d19c0e31e1168');
defined('CHENGLAN_APPSECRET') or define('CHENGLAN_APPSECRET','da72cd609ea073beb155e905673f2f76');
//橙蓝服务商
defined('CHENGLAN_MCH') or define('CHENGLAN_MCH','wx0dd0829415ec47da');
defined('CHENGLAN_MCHKEY') or define('CHENGLAN_MCHKEY','S9r6LCNS2PEG9TIyEiDBQq4ayks3ufR8');

//淘宝客小程序
defined('TBK_APPID') or define('TBK_APPID','wx34fca60ac92805ba');
defined('TBK_APPSECRET') or define('TBK_APPSECRET','a31b805596e8ceb60f7c1e7133106557');