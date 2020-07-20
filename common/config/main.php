<?php
if($_SERVER['HTTPS'] === 'on'){
	$http = 'https://';
}else{
	$http = 'http://';
}
$MultiDomain = [
	1 => 'api.',
	2 => 'admin.',
];
foreach($MultiDomain as $key => $value){
	if(strpos($_SERVER['HTTP_HOST'], $value) !== false){
		$findResult = true;
		$findWord = $value;
	}
}
if(empty($findResult)){
	$HostInfo = $_SERVER['HTTP_HOST'];
}else{
	$HostInfo = str_replace($findWord, '', $_SERVER['HTTP_HOST']);
}

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
	    'language'=>'ru-RU',
	    'request' => [
		    'csrfParam' => '_key_application',
		    'cookieValidationKey' => 'd251c5e7f26227c3c49f146bbeb91704',
		    'csrfCookie' => [
		    	'domain' => '.'.$HostInfo,
		    ]
	    ],
	    'session' => [
		    'name' => 'Browser-Client',
		    'class' => 'yii\web\DbSession',
		    'sessionTable' => 'session',
		    'cookieParams' => [
			    'httpOnly' => true,
			    'lifetime' => 3600*24*30*12,
			    'domain' => '.'.$HostInfo,
		    ],
		    'timeout' => 3600*24*30*12,
		    'useCookies' => true,
		    'flashParam' => '__flash'
	    ],
	    'user' => [
		    'class' => 'yii\web\User',
		    'identityClass' => 'common\models\User',
		    'enableAutoLogin' => true,
		    'loginUrl' => ['/signup.html'],
		    'identityCookie' => [
			    'name' => '_user_authorized',
			    'httpOnly' => true,
			    'domain' => '.'.$HostInfo
		    ],
	    ],
	    'db' => [
		    'class' => 'yii\db\Connection',
		    'dsn' => 'mysql:host=localhost;dbname=klever',
		    'username' => 'mysql',
		    'password' => 'mysql',
		    'charset' => 'utf8',
	    ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
