<?php

use yii\widgets\ListView;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Редактор книг';
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

Modal::begin([
	'header' => '<h4>Форма добавления</h4>',
	'toggleButton' => ['label' => 'Добавить книгу', 'class' => 'btn btn-primary'],
]);
$form = ActiveForm::begin();
    echo $form->field($model, 'name')->textInput(['placeholder' => 'Наименование книги'])->label(false);
    echo $form->field($model, 'publishing')->textInput(['placeholder' => 'Издательский дом'])->label(false);
	echo $form->field($model, 'slug')->textInput(['placeholder' => 'Ссылка'])->label(false);
    echo Html::button('Сохранить', ['class' => 'btn btn-info']);
ActiveForm::end();
Modal::end();
echo ListView::widget([
	'dataProvider' => $provider,
	'itemView' => '_books',
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

