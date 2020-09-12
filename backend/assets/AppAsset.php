<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/backend/web';
    public $css = [
        'bower_components/bootstrap/dist/css/bootstrap.min.css',
        'bower_components/font-awesome/css/font-awesome.min.css',
        'bower_components/Ionicons/css/ionicons.min.css',
        'dist/css/AdminLTE.min.css',
        'plugins/iCheck/square/blue.css',
        'dist/css/style.css',

    ];
    public $js = [
        'bower_components/bootstrap/dist/js/bootstrap.min.js',
       
    ];
    public $depends = [
         //'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
