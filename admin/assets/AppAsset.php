<?php

namespace admin\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
	public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';
	public $css = [
		'css/AdminLTE.min.css',
		'css/skins/_all-skins.min.css',
	];
	public $js = [
		'js/app.min.js'
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapPluginAsset',
		//'rmrevin\yii\fontawesome\AssetBundle',
	];
}
