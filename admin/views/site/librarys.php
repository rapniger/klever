<?php

use yii\widgets\ListView;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Редактор библиотеки';

$listLayout = "
	<div class='row'>
		<div class='col-sm-12'>
			<div class='card'>
				<div class='card-header'>
					<h3 class='card-title'>Таблица</h3>
				</div>
				<div class='card-body'>
					<table class='table table-bordered'>
						<thead>
							<tr>
								<th style='width: 10px'>ID</th>
								<th>Имя и Фамилия автора</th>
								<th>Наименование книги</th>
								<th>Издательский дом</th>
								<th style='width: 80px'>Действия</th>
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
$map = ArrayHelper::map($book, 'id', 'title');
Modal::begin([
	'header' => '<h4>Форма добавления</h4>',
	'toggleButton' => ['label' => 'Добавить в библиотеку', 'class' => 'btn btn-primary'],
]);
$form = ActiveForm::begin([
	'id' => 'add-form',
	'action' => false,
	'enableAjaxValidation' => true,
	'validationUrl' => '/validate.html',
]);
echo $form->field($model, 'name')->textInput(['placeholder' => 'Имя автора'])->label(false);
echo $form->field($model, 'subname')->textInput(['placeholder' => 'Фамилия автора'])->label(false);
echo $form->field($model, 'slug')->textInput(['placeholder' => 'Ссылка'])->label(false);
echo $form->field($model, 'idBook')->dropDownList($map)->label(false);
echo Html::button('Сохранить', ['class' => 'btn btn-info']);
ActiveForm::end();
Modal::end();
echo ListView::widget([
	'dataProvider' => $provider,
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
		'prevPageLabel' => '<i class="fa fa-angle-double-left"></i>',
		'nextPageLabel' => '<i class="fa fa-angle-double-right"></i>',
		'disabledPageCssClass' => 'page-link',
		'linkOptions' => [
			'class' => 'page-link'
		],
		'maxButtonCount' => 3,
		'disableCurrentPageButton' => true,
	]
]);
?>
