<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=mp_media_service',
            'username' => 'homestead',
            'password' => 'secret',
            'charset' => 'utf8',
        ],
        'awssdk' => [
            'class' => \common\components\aws\AwsSdk::className(),
            'sdkOptions' => [
                'bucket' => 'mp-media-dev',
                'region' => 'ap-southeast-1',
                'credentials' => [
                    'key' => 'AKIAJKCBGIWY5OCQZZBQ',
                    'secret' => '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',
                ],
            ],
        ],
        'hashids' => [
            'class' => \common\components\hashid\Hashid::className(),
            'hashOptions' => [
                'salt' => 'salt'
            ]
        ]
    ],
];
