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
	    'request' => [
		    'parsers' => [
			    'application/json' => 'yii\web\JsonParser',
		    ]
	    ],
	    /*
	    'user' => [
		    'identityClass' => 'common\models\User',
		    'enableAutoLogin' => true,
		    'identityCookie' => ['name' => '_user', 'httpOnly' => true],
	    ],
	    'session' => [
		    // this is the name of the session cookie used for login on the frontend
		    'name' => 'app-site',
	    ],
	    'log' => [
		    'traceLevel' => YII_DEBUG ? 3 : 0,
		    'targets' => [
			    [
				    'class' => 'yii\log\FileTarget',
				    'levels' => ['error', 'warning'],
			    ],
		    ],
	    ],*/
	    'urlManager' => [
		    'hostInfo' => $APIHostInfo,
		    'baseUrl' => '/',
		    'enablePrettyUrl' => true,
		    'enableStrictParsing' => true,
		    'showScriptName' => false,
		    'rules' => [
			    '/' => 'doc/index',
			    'GET v1/author/readAuthors/<page>' => 'v1/author/authors',
			    'POST v1/author/create' => 'v1/author/create-author',
			    'POST v1/author/update' => 'v1/author/update-author',
			    'POST v1/author/delete' => 'v1/author/delete-author',
			    'GET v1/book/readBooks/<page>' => 'v1/book/books',
			    'POST v1/book/create' => 'v1/book/create-book',
			    'POST v1/book/update' => 'v1/book/update-book',
			    'POST v1/book/delete' => 'v1/book/delete-book',
			    'GET v1/library/readLibrarys/<page>' => 'v1/library/librarys',
			    'POST v1/library/update' => 'v1/library/update-library',
			    /*[
			    	'class' => 'yii\rest\UrlRule',
				    'controller' => 'author',
			    ],*/
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
		'v1' => [
			'class' => 'api\modules\v1\Module',
		],
	],
    'params' => $params,
];
