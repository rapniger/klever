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

$HostInfo = str_replace('admin.', '', $_SERVER['HTTP_HOST']);

$APIHostInfo = $http.'api.'.$HostInfo;
$AdminHostInfo = $http.$_SERVER['HTTP_HOST'];
$ApplicationHostInfo = $http.$HostInfo;

return [
    'id' => 'app-admin',
	'language' => 'RU-ru',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'admin\controllers',
    'bootstrap' => ['log'],
    'components' => [
	    'view' => [
		    'theme' => [
			    'pathMap' => [
				    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
			    ],
		    ],
	    ],
	    'errorHandler' => [
		    'errorAction' => 'site/error',
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
		    'hostInfo' => $AdminHostInfo,
		    'baseUrl' => '/',
		    'enablePrettyUrl' => true,
		    'enableStrictParsing' => true,
		    'showScriptName' => false,
		    'suffix' => '.html',
		    'rules' => [
			    '/' => 'site/index',
			    'logout' => 'site/logout',
			    'profile' => 'site/profile',
			    'validate' => 'site/validate',
			    'books' => 'site/books',
			    'book/<slug:[a-z0-9_\-]+>' => 'site/book/',
			    'authors' => 'site/authors',
			    'author/<slug:[a-z0-9_\-]+>' => 'site/author/',
			    'librarys' => 'site/librarys',
			    'library/<slug:[a-z0-9_\-]+>' => 'site/library/'
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
	    'urlManagerApplication' => [
		    'class'=>'yii\web\UrlManager',
		    'hostInfo' => $ApplicationHostInfo,
		    'baseUrl' => '/',
		    'enablePrettyUrl'=>true,
		    'showScriptName'=>false,
		    'suffix' => '.html',
	    ],
    ],
    'params' => $params,
];
