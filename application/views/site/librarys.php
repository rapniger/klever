<?php

use yii\widgets\ListView;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Библиотека';

$listLayout = "
	<div class='row'>
		<div class='col-sm-12' style='margin-top: 20px'>
			<div class='card'>
				<div class='card-header'>
					<h3 class='card-title'>Библиотека</h3>
				</div>
				<div class='card-body'>
					<table class='table table-bordered'>
						<thead>
							<tr>
								<th style='width: 10px'>ID</th>
								<th>Имя и Фамилия автора</th>
								<th>Наименование книги</th>
								<th>Издательский дом</th>
							</tr>
						</thead>
						<tbody>
							{items}
						</tbody>
					</table>
				</div>
				<div class='card-footer clearfix'>
					{pager}
				</div>
			</div>
		</div>
	</div>
";
echo ListView::widget([
	'dataProvider' => $provider['pagination'],
	'itemView' => '_librarys',
	'options' => [
		'id' => false,
		'tag' => 'div',
		'class' => 'container-fluid'
	],
	'emptyText' => 'Данные не найдены',
	'emptyTextOptions' => [
		'tag' => 'h2',
		'class' => 'text-center',
	],
	'layout' => $listLayout,
	'itemOptions' => [
		'tag' => 'tr'
	],
	'pager' => [
		'options' => [
			'tag' => 'ul',
			'class' => 'pagination justify-content-center'
		],
		'pageCssClass' => 'page-item',
		'prevPageCssClass' => 'page-item',
		'nextPageCssClass' => 'page-item',
		'activePageCssClass' => 'page-item',
		'prevPageLabel' => 'Назад',
		'nextPageLabel' => 'Вперед',
		'disabledPageCssClass' => 'page-link',
		'linkOptions' => [
			'class' => 'page-link'
		],
		'maxButtonCount' => 3,
		'disableCurrentPageButton' => true,
	]
]);
?>

