<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=marketplace.cbcfuhpj9txw.us-east-1.rds.amazonaws.com;dbname=mp_media_service_test',
            'username' => 'DbSmsMarketPlace',
            'password' => 'YAU872#11L',
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
                'salt' => '14GKaPpVrwlGU25V2bH2WAT1'
            ]
        ],
    ],
];
