<?php
if($_SERVER['HTTPS'] === 'on'){
	$http = 'https://';
}else{
	$http = 'http://';
}
$APIHostInfo = $http.'api.'.$_SERVER['HTTP_HOST'];
$AdminHostInfo = $http.'admin.'.$_SERVER['HTTP_HOST'];
$ApplicationHostInfo = $http.$_SERVER['HTTP_HOST'];

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'application\controllers',
    'components' => [
        /*'request' => [
            'csrfParam' => '_csrf-app',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_user', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'app-site',
        ],*/
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
	    'urlManager' => [
		    'hostInfo' => $ApplicationHostInfo,
		    'baseUrl' => '/',
		    'enablePrettyUrl' => true,
		    'enableStrictParsing' => true,
		    'showScriptName' => false,
		    'suffix' => '.html',
		    'rules' => [
			    '/' => 'site/index',
			    'signup' => 'site/signup',
			    'action/response-signup' => 'site/response-signup',
			    'register' => 'site/register',
			    'action/response-register' => 'site/response-register',
			    'logout' => 'site/logout',
			    'profile' => 'site/profile',
			    'validate' => 'site/validate',
			    'librarys' => 'site/librarys',
			    'librarys/<page>' => 'site/librarys',
		    ],
	    ],
	    'urlManagerAPI' => [
		    'class'=>'yii\web\UrlManager',
		    'hostInfo' => $APIHostInfo,
		    'baseUrl' => '/',
		    'enablePrettyUrl'=>true,
		    'showScriptName'=>false,
		    'suffix' => '.html',
	    ],
	    'urlManagerAdmin' => [
		    'class'=>'yii\web\UrlManager',
		    'hostInfo' => $AdminHostInfo,
		    'baseUrl' => '/',
		    'enablePrettyUrl'=>true,
		    'showScriptName'=>false,
		    'suffix' => '.html',
	    ],
    ],
    'params' => $params,
];
