<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'es', // spanish
    'timeZone'  => 'America/Bogota',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'ayudante' => [
            'class' => 'common\components\Ayudante',
        ],
        'notificador' => [
            'class' => 'common\components\Notificador',
        ],
        'siteApi' => [
            'class' => 'mongosoft\soapclient\Client',
            'url' => 'http://190.143.101.58:2998/',
            'options' => [
                'cache_wsdl' => 'WSDL_CACHE_NONE',
            ],
        ]
    ],
];
