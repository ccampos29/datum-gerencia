<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/../../common/config/params-local.php', require __DIR__ . '/params.php', require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'urlManagerAdministracion' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => '@web/../../administracion/web',
            'showScriptName' => FALSE,
            'enablePrettyUrl' => TRUE,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => ['api\User', 'api\Checklist', 'api\Combustible'], 
                    'extraPatterns' => [
                        'POST authenticate'=>'authenticate',//validado
                        'GET getvehiclebyuser' => 'checklist/getvehiclebyuser',//validado
                        'GET getuserbyvehicle' => 'checklist/getuserbyvehicle',//validado
                        'GET consultamedicion' => 'checklist/consultamedicion',//validado
                        'GET tiposchecklist' => 'checklist/tiposchecklist',//validado
                        'POST obtenerperiodicidadchecklist' => 'checklist/obtenerperiodicidadchecklist',//validado
                        'POST calificacioneschecklist' => 'checklist/calificacioneschecklist',// validado las empresas id tienen problemas hay que corregir eso con los desarrolladores
                        'POST calificarchecklist' => 'checklist/calificarchecklist',
                        'POST subirfotochecklist' => 'checklist/subirfotochecklist',//validado
                        'GET createcombustible' => 'combustible/createcombustible',
                        'GET getdepartamentos' => 'combustible/getdepartamentos',
                        'GET getmunicipios' => 'combustible/getmunicipios',
                        'POST Storecombustible' => 'combustible/storecombustible',
                    ]
                ],
            ],
        ],
    ],
    'modules' => ['gridview' => ['class' => 'kartik\grid\Module']],
    'params' => $params,
];
