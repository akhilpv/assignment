<?php
$backendParams   = require __DIR__ . '/../../backend/config/main.php';

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@uploadPath' => '/uploads',
        '@imagePath' => '/backend/web/images/',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'backendEmails' => [
            'class' => 'common\components\BackendEmails',
        ],

        'permissions' => [
                'class' => 'common\components\Permissions',
        ],
        'generalFunctions' => [
            'class' => 'common\components\GeneralFunctions',
        ],
        'urlManagerBackend' => [
            'class'               => 'yii\web\UrlManager',            
            'enablePrettyUrl'     => true,
            'showScriptName'      => true,
            'scriptUrl'           => '/backend.php',
            'enableStrictParsing' => false,
            'rules'               => $backendParams['components']['urlManager']['rules'],
        ],
    ],
];
