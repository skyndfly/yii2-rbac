<?php

use app\auth\UserIdentity;
use yii\symfonymailer\Mailer;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'RBAC',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'RKUPcEpgi3RLV79F8HgYp_0sI1KKPZjl',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => UserIdentity::class,
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => Mailer::class,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'GET posts' => 'post/index',
                'GET lk' => 'admin/admin-page/index',
                'GET lk/users' => 'admin/users/index',
                'GET lk/users/create' => 'admin/users/create',
                'POST lk/users/store' => 'admin/users/store',
                'GET lk/rbac' => 'admin/rbac/index',
                'GET lk/rbac/role/create' => 'admin/rbac/role-create',
                'GET lk/rbac/role/<role>/bind-permission' => 'admin/rbac/bind-permission-to-role',
                'POST lk/rbac/role/bind-permission' => 'admin/rbac/store-permission-to-role',
                'GET lk/rbac/permission/create' => 'admin/rbac/permission-create',
                'GET lk/rbac/role/view/<role>' => 'admin/rbac/role-view',
                'POST lk/rbac/role/store' => 'admin/rbac/role-store',
                'GET lk/articles' => 'admin/articles/index',
                'GET site/register' => 'site/register',
                'POST site/signup' => 'site/signup',
                'POST site/authorize' => 'site/authorize',
            ],
        ],
    ],
    'params' => $params,
    'container' => [
        'definitions' => [
            \app\services\user\contracts\PaginateUsersServiceContract::class => \app\services\user\PaginateUsersService::class,
            \app\services\user\contracts\UserRegisterServiceContract::class => \app\services\user\UserRegisterService::class,
            \app\services\user\contracts\UserAuthorizeServiceContract::class => \app\services\user\UserAuthorizeService::class,
        ]
    ]
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
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
