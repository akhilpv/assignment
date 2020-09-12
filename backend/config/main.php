<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
  
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\AdminUsers',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
            'yii\web\JqueryAsset' => false,
            ],
        ], 
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer', 
            'useFileTransport' => false,
            'transport' =>
             [ 
            'class' => 'Swift_SmtpTransport', 
            'host' => 'smtp.gmail.com',
            'username' => 'buildyourwebapp@gmail.com',
            'password' => 'tuyzoxiygxtqfvpy', 
            'port' => '587',
            'encryption' => 'tls',
            ], 
        ],

        'i18n' => [
            'translations' => [             
                'users*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@backend/messages',
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        'main' => 'main.php',        
                        'users/alerts' => 'alerts.php',
                        'users/contents' => 'contents.php',                                              
                    ],
                ],
            ],
        ],    
    
    
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => true,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                     'controller' => ['api-get-data','api-get-data'], 
                     'pluralize'=>false,
                     'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],                     
                ],

                'GET,HEAD api/home'  => 'api-get-data/home',
                'api/<controller:[\w-]+>'=>'rest-package/list',
                'api/<controller:[\w-]+>/<id:\d+>'=>'rest-package/view',             
               
            ],
        ],
        

    ],
    'params' => $params,
];
