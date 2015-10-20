<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        function () {
            $path = '/';
            $filename = basename(Yii::$app->getRequest()->getScriptFile());
            Yii::$app->getRequest()->setScriptUrl($path . $filename);
            Yii::$app->getRequest()->setBaseUrl(rtrim($path, '/'));
        },
        'log',
        // ...
    ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => array(

                '<module:costs>/<action:(update-cost|delete-cost)>/<id:\d+>' => '<module>/default/<action>',
                '<module:costs>/<action:(archive|create-category|update|add)>' => '<module>/default/<action>',

                '<module:income>/<action:(update-income|delete-income)>/<id:\d+>' => '<module>/default/<action>',
                '<module:income>/<action:(archive|create-income|create-category)>' => '<module>/default/<action>',


                '<module:debts>/<action:(change-status|update-debt|delete-debt)>/<id:\d+>' => '<module>/default/<action>',
                '<module:debts>/<action:(add)>' => '<module>/default/<action>',

                '<module:savings>/<action:(update|delete)>/<id:\d+>' => '<module>/default/<action>',
                '<module:savings>/<action:(add)>' => '<module>/default/<action>',


                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'modules' => [
        'costs' => [
            'class' => 'frontend\modules\costs\Costs',
            'layout' => '/profile'
        ],
        'income' => [
            'class' => 'frontend\modules\income\Income',
            'layout' => '/profile'
        ],
        'debts' => [
            'class' => 'frontend\modules\debts\Debts',
            'layout' => '/profile'
        ],
        'savings' => [
            'class' => 'frontend\modules\savings\Savings',
            'layout' => '/profile'
        ],
    ],
    'params' => $params,
];
