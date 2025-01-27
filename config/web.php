<?php

$params = require __DIR__ . '/params.php';
$healthcare_db_auth = require __DIR__ . '/db/healthcare_db_auth.php';
$healthcare_db = require __DIR__ . '/db/healthcare_db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'rbac'
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'request' => [
            'cookieValidationKey' => 'SQ4ktLsm5pLWGjPQZ2NdVm5YwAFIym3Z',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'mdm\admin\models\User',
            'loginUrl' => ['site/login'],
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
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
        'i18n' => [
            'translations' => [
                'yii2-ajaxcrud' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2ajaxcrud/ajaxcrud/messages',
                    'sourceLanguage' => 'en',
                ],
            ]
        ],
        'db' => $healthcare_db_auth,
        'healthcare_db' => $healthcare_db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'dashboard' => 'admin/dashboard/v1',
            ],
        ],

    ],

    'params' => $params,

    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'rbac' => [
            'class' => 'mdm\admin\Module',
            'layout' => '/adminlte',
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin', 'super-admin'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'layout' => '/adminlte',
        ],
        'patient' => [
            'class' => 'app\modules\patient\Module',
            'layout' => '/adminlte',
        ],
        'doctor' => [
            'class' => 'app\modules\doctor\Module',
            'layout' => '/adminlte',
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'crud' => [
                    'class' => 'yii\gii\generators\crud\Generator',
                    'templates' => [
                        'yii2-adminlte3' => '@vendor/hail812/yii2-adminlte3/src/gii/generators/crud/default'
                    ]
                ]
            ],
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['super-admin'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ],
        // 'debug' => [
        //     'class' => 'debug\gii\Module',
        //     'as access' => [
        //         'class' => 'yii\filters\AccessControl',
        //         'rules' => [
        //             [
        //                 'allow' => true,
        //                 'roles' => ['super-admin'],
        //             ],
        //             [
        //                 'allow' => false,
        //             ],
        //         ],
        //     ],
        // ],


    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'yii2-adminlte3' => '@vendor/hail812/yii2-adminlte3/src/gii/generators/crud/default'
                ]
            ]
        ]
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
