<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => '',
            'username' => '',
            'password' => '',
            'charset' => '',
        ],
        'awssdk' => [
            'class' => \common\components\aws\AwsSdk::className(),
            'sdkOptions' => [
                'bucket' => '',
                'region' => '',
                'credentials' => [
                    'key' => '',
                    'secret' => '',
                ],
            ],
        ],
        'hashids' => [
            'class' => \common\components\hashid\Hashid::className(),
            'hashOptions' => [
                'salt' => ''
            ]
        ]
    ],
];
