<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'ticketIdGenerator' => [
            'class' => \common\components\ticket\IdGenerator::className(),
            'tickets' => [
                'media' => [
                    'timeAccuracy' => \common\components\ticket\IdGenerator::TIME_ACCURACY_SECOND,
                    'epoch' => gmmktime(0, 0, 0, 1, 1, 2016),
                    'sequenceBit' => 13,
                ],
                'object' => [
                    'timeAccuracy' => \common\components\ticket\IdGenerator::TIME_ACCURACY_SECOND,
                    'epoch' => gmmktime(0, 0, 0, 1, 1, 2016),
                    'sequenceBit' => 13,
                ],
            ],
        ],
    ],
];
