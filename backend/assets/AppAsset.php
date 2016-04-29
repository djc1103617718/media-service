<?php

namespace backend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'bootstrap/dashboard.css',
        'bootstrap/signin.css',
        'bootstrap/dist/css/bootstrap.min.css',
        'bootstrap/dist/css/bootstrap.css',
    ];
    public $js = [
        'bootstrap/dist/js/bootstrap.js',
        'bootstrap/dist/js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yiiassets\bootbox\BootBoxAsset',
    ];
}
