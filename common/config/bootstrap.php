<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@site', dirname(dirname(__DIR__)) . '/site');

//admin owid
defined('ADMIN_OWID') or define('ADMIN_OWID',39);

defined('CHENGLAN_DIANCAN_APPID') or define('CHENGLAN_DIANCAN_APPID','wx0dd0829415ec47da');
defined('CHENGLAN_DIANCAN_APPSECRET') or define('CHENGLAN_DIANCAN_APPSECRET','d28911cd2ad0a767bb76e7ab237f3656');