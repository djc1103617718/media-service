<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-upload',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'upload\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request' => [
            'enableCsrfValidation' => false,
        ],
        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON,
        ],
        'urlManager' => [
            'class' => \yii\web\UrlManager::className(),
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [
                'categories/<category_url_name:[0-9a-z-_]+>/medias' => 'media/create',
            ]
        ],
    ],
    'params' => $params,
];
