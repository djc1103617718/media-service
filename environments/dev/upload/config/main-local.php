<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
    // configuration adjustments for 'dev' environment
    'bootstrap' => ['debug', 'gii'],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.10.1'],
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.10.1'],
        ],
    ],
    'on beforeAction' => function ($event) {
        if ($event->isValid) {
            /* @var yii\base\Action $action */
            $action = $event->action;
            /* @var yii\base\Module $module */
            $module = $action->controller->module;
            if (!is_null($module) && in_array($module->uniqueId, ['debug', 'gii'])) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
            }
        }
    },
];

return $config;
