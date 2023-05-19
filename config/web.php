<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU', 
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app'       => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'iHJRmiE30qxWpFJx7khGqtkDczonibjs',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'error/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'useFileTransport' => false,
            'transport' => [
                'scheme' => 'smtp',
                'host' => 'smtp.yandex.ru',
                'username' => 'zakaz@MrTruman.ru',
                'password' => 'JkL159951',
                'port' => '465',
                'encryption' => 'ssl',
            ],
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

                //Открытые 
                "/"=>"open/index",
                '/question/create'=>"open/create",
                '/questions/view/<slug:\w+>'=>'open/view',
                '/questions/change/<slug:\w+>'=>'open/change',
                /* Поиск */
                '/questions/search'=>"open/search",
                /* Поиск */
                /* Модерация */
                '/questions/moderation'=>"open/moderation",
                '/questions/updatestatus'=>"open/updatestatus",
                '/questions/timestatus'=>"open/time",
                '/questions/return/<slug:\w+>'=>"open/return",
                /* Модерация */
                //Закрытые 
                '/questions/close'=>"close/index",
                '/questions/close/<slug:\w+>'=>"close/view",
                '/question/filter'=>"close/filter",
                //Голосование
                '/questions/voting'=>"voiting/voting",
                '/questions/voting/<slug:\w+>'=>"voiting/votingview",
                //МОИ ВОПРОСЫ
                '/questions/myquestions'=>'my/index',
                '/questions/myquestionsfilter/<slug:\w+>'=>'my/filter',
                '/questions/myquestions/<slug:\w+>'=>'my/view',
                '/questions/myquestions/<page:\d+>' => 'my/index',
                //МОИ ОТВЕТЫ
                '/answer/myanswers/view/<slug:\w+>'=>'answers/myanswersview',
                '/answer/myanswers'=>'answers/myanswers',
                //МОИ ГОЛОСОВАНИЯ
                '/questions/myvoiting'=>'myvoiting/index',
                '/questions/myvoiting/<slug:\w+>'=>'myvoiting/view',
                //Избранные
                '/favourit'=>'favourites/index',
                '/favourit/create'=>'favourites/create',
                '/favourit/delete'=>'favourites/delete',

                "/login"=>'registration/login',
                '/main'=>'registration/main',
                '/logout'=>'registration/logout',
                "/registration"=>'registration/registration',
                "/restore"=>"registration/restore",
                "/ChangeEmail/<hash>"=>"registration/changeemail",
                "/activate/<hash>"=>"registration/activate",
                "/changepassword"=>"registration/changepassword",
                "/user/clearimg"=>"registration/clearimg",
                /* Пользователь */
                "/profile"=>'user/index',
                "/profile/download"=>'user/download',
                "/profile/ajx/get"=>'user/get',
                "/profile/ajx/update"=>'user/update',
                /* Пользователь */
                /* Вопросы */
              
               
                
                
                
             
                
                
               
                /* Вопросы */
                /* Лайки/Дизлайки */
                '/like'=>'like/index',
                '/like_block'=>'like/block',
                '/dislike'=>'dislike/index',
                /* Лайки/Дизлайки */
                /* Ответы */
                '/answer/create/<slug:\w+>'=>"answers/create",
                '/viewanswer'=>'view/index',
                '/text'=>'open/text',
                
                /* Ответы */
          
                /* Чат */
                '/chat'=>"chat/index",
                '/list_chat'=>"chat/list",
                '/chatadmin/<slug:\w+>'=>"chat/admin",
                /* Чат */
                /* Политика */
                '/privacy'=>"privacy/index",
                /* Политика */
                /* Правила */
                '/read'=>"user/read",
                '/readstatus'=>"user/status",
                /* Правила */
               
                /* Список пользователей */
                '/user'=>"user/userlist",
                /* Список  пользователей */
                /* Изменение минимального платежа */
                '/price'=>"price/index",
                /* Изменение минимального платежа */
                /* Изменение времени */
                '/questions/dateupdate/<slug:\w+>'=>"open/dateupdate",
                /* Изменение времени */
                /* Жалобы */
                '/complaints/'=>'complaints/index',
                '/complaints/delete/<slug:\w+>'=>'complaints/delete',
                /* Жалобы */
            ],
        ],
    ],
    'params' => $params,
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
