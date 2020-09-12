<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/backend/web';
    public $css = [
        'plugins/components/crop/css/jquery.Jcrop.min.css',
        'bower_components/bootstrap/dist/css/bootstrap.min.css',
        'bower_components/font-awesome/css/font-awesome.min.css',
        'bower_components/Ionicons/css/ionicons.min.css',
        'bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
        'plugins/iCheck/all.css',
        'bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css',
        'plugins/timepicker/bootstrap-timepicker.min.css',
        'bower_components/select2/dist/css/select2.min.css',
        'dist/css/AdminLTE.min.css',
        'dist/css/skins/_all-skins.min.css',
        'dist/css/style.css',
    ];
    public $js = [
        'bower_components/bootstrap/dist/js/bootstrap.min.js',
        'bower_components/select2/dist/js/select2.full.min.js',
        'plugins/input-mask/jquery.inputmask.js',
        'plugins/input-mask/jquery.inputmask.date.extensions.js',
        'plugins/input-mask/jquery.inputmask.extensions.js',
        'bower_components/moment/min/moment.min.js',
        'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
        'bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
        'plugins/timepicker/bootstrap-timepicker.min.js',
        'bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
        'bower_components/jquery-knob/dist/jquery.knob.min.js',
        'bower_components/bootstrap-daterangepicker/daterangepicker.js',
        'plugins/iCheck/icheck.min.js',
        'bower_components/fastclick/lib/fastclick.js',
        'dist/js/adminlte.min.js',
        'dist/js/demo.js',
        'plugins/components/crop/js/jquery.Jcrop.min.js',
        'plugins/components/crop/js/jquery.color.js',
    ];
    public $depends = [
         //'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
