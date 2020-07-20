<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
if($_SERVER['HTTPS'] === 'on'){
	$http = 'https://';
}else{
	$http = 'http://';
}

$HostInfo = str_replace('api.', '', $_SERVER['HTTP_HOST']);

$APIHostInfo = $http.$_SERVER['HTTP_HOST'];
$AdminHostInfo = $http.'admin.'.$HostInfo;
$ApplicationHostInfo = $http.$HostInfo;

return [
    'id' => 'app-admin',
	'language' => 'RU-ru',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'components' => [
	    
	    'errorHandler' => [
		    'errorAction' => 'doc/error',
	    ],
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
	    'urlManager' => [
		    'hostInfo' => $APIHostInfo,
		    'baseUrl' => '/',
		    'enablePrettyUrl' => true,
		    'enableStrictParsing' => true,
		    'showScriptName' => false,
		    'suffix' => '.html',
		    'rules' => [
			    '/' => 'doc/index',
			    'rest/'
		    ],
	    ],
	    'urlManagerAdmin' => [
		    'class'=>'yii\web\UrlManager',
		    'hostInfo' => $AdminHostInfo,
		    'baseUrl' => '/',
		    'enablePrettyUrl'=>true,
		    'showScriptName'=>false,
		    'suffix' => '.html',
	    ],
	    'urlManagerApplication' => [
		    'class'=>'yii\web\UrlManager',
		    'hostInfo' => $ApplicationHostInfo,
		    'baseUrl' => '/',
		    'enablePrettyUrl'=>true,
		    'showScriptName'=>false,
		    'suffix' => '.html',
	    ],
    ],
	'modules' => [
		'edit' => [
			'class' => 'api\modules\v1\Module',
		],
	],
    'params' => $params,
];
