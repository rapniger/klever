<?php
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

NavBar::begin([
    'id' => false,
    'brandLabel' => 'Тестовое задание',
    'options' => [
        'tag' => 'header',
        'class' => 'navbar-light navbar-fixed-top navbar-expand-lg',
        'style' => 'background-color: #e3f2fd;'
    ],
]);
if(yii::$app->user->isGuest){
	Nav::begin([
		'id' => false,
		'options' => [
			'class' => 'nav navbar-nav btn-group ml-auto'
		],
		'items' => [
			[
				'label' => 'Главная страница',
				'url' => Yii::$app->urlManagerApplication->hostInfo
			],
		]
	]);
	Nav::end();
}
if(!yii::$app->user->isGuest){
	Nav::begin([
		'id' => false,
		'options' => [
			'class' => 'nav navbar-nav btn-group ml-auto'
		],
		'items' => [
			[
				'label' => 'Главная страница',
				'url' => Yii::$app->urlManagerApplication->hostInfo
			],
			[
				'label' => 'Админка',
				'url' => Yii::$app->urlManagerAdmin->hostInfo
			]
		]
	]);
	Nav::end();
}
NavBar::end();