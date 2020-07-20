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
				'label' => 'Книги',
				'url' => ['/book']
			],
			[
				'label' => 'Авторы',
				'url' => ['/author']
			],
			[
				'label' => 'Документация',
				'url' => Yii::$app->urlManagerAPI->hostInfo.'/',
			],
			[
				'label' => 'Меню',
				'tag' => 'span',
				'options' => [
					'id' => false,
					'class' => 'dropdown',
				],
				'items' => [
					['label' => 'Авторизация', 'options'=> ['id'=>false], 'url' => ['/signup']],
					['label' => 'Регистрация', 'options'=> ['id'=>false], 'url' => ['/register']],
				],
				'url' => ['/']
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
				'label' => 'Книги',
				'url' => ['/book']
			],
			[
				'label' => 'Авторы',
				'url' => ['/author']
			],
			[
				'label' => 'Библиотека',
				'url' => ['/library']
			],
			[
				'label' => 'Документация',
				'url' => Yii::$app->urlManagerAPI->hostInfo.'/',
			],
			[
				'label' => 'Админка',
				'url' => Yii::$app->urlManagerAdmin->hostInfo.'/'
			],
			[
				'label' => 'Меню',
				'tag' => 'span',
				'options' => [
					'id' => false,
					'class' => 'dropdown',
				],
				'items' => [
					['label' => 'Профиль', 'options'=> ['id'=>false], 'url' => ['/profile']],
					['label' => 'Выйти', 'options'=> ['id'=>false], 'url' => ['/logout']],
				],
				'url' => ['/']
			],
		]
	]);
	Nav::end();
}
NavBar::end();