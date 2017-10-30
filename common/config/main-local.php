<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=120.77.181.89;dbname=colorsite',
            'username' => 'root',
            'password' => 'lrongZe*+-/214',
            'charset' => 'utf8',
            'tablePrefix' => 'cs_',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.qq.com',
//                'username' => '1946755280@qq.com',
//                'password' => 'rvlsdcplroakhgcf',
//                'port' => '25',
                'host' => 'smtpdm.aliyun.com',
                'username' => 'admin@email.326108993.com',
                'password' => 'SA523BERxia',
                'port' => '80',
                'encryption' => 'tls',
            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['admin@email.326108993.com'=>'colorsite']
            ],
        ],
    ],
];
