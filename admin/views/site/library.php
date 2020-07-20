<?php

use yii\widgets\ListView;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Редактор библиотеки';

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
echo $form->field($addModel, 'name')->textInput(['placeholder' => 'Имя автора'])->label(false);
echo $form->field($addModel, 'subname')->textInput(['placeholder' => 'Фамилия автора'])->label(false);
echo $form->field($addModel, 'slug')->textInput(['placeholder' => 'Ссылка'])->label(false);
echo $form->field($addModel, 'idBook')->dropDownList($map)->label(false);
echo Html::button('Сохранить', ['class' => 'btn btn-info']);
ActiveForm::end();
Modal::end();
?>
<div class="row" style="margin-top: 40px;">
	<div class="col-md-12" style="margin: 20px 0px">
		<a class="btn btn-primary" href='/librarys.html'>
			Вернуться
		</a>
	</div>
	<div class="col-md-3">
		<img src="https://c7.hotpng.com/preview/939/991/695/download-book-rectangle-books-png-image-thumbnail.jpg" height="90%" width="90%" />
	</div>
	<div class="col-md-9">
        <h4><b>Автор книги:</b> <?= $library->name.' '.$library->subname?></h4>
		<h4><b>Наименование книги:</b> <?= $library->book->title?></h4>
		<p><b>Ссылка на автора:</b> <a href="/author/<?= $library->slug?>.html"><?= $library->book->slug?></a></p>
		<p><b>Ссылка на книгу:</b> <a href="/book/<?= $library->book->slug?>"><?= $library->book->slug?></a></p>
		<p><b>Издательский дом:</b> <?= $library->book->publishing?></p>
		<?php
		Modal::begin([
			'id' => 'update-book',
			'header' => '<h4>Форма редактирования</h4>',
			'toggleButton' => ['label' => 'Обновить книгу', 'class' => 'btn btn-info'],
		]);
		$form = ActiveForm::begin([
			'id' => 'update-form',
			'action' => false,
			'enableAjaxValidation' => true,
			'validationUrl' => '/validate.html',
		]);
		echo $form->field($updateModel, 'name')->textInput(['value' => $library->name, 'placeholder' => 'Имя автора'])->label(false);
        echo $form->field($updateModel, 'subname')->textInput(['value' => $library->subname, 'placeholder' => 'Фамилия автора'])->label(false);
        echo $form->field($updateModel, 'slug')->textInput(['value' => $library->slug, 'placeholder' => 'Ссылка'])->label(false);
        echo $form->field($updateModel, 'idBook')->dropDownList($map,['value' => $library->book->id])->label(false);
        echo Html::button('Обновить', ['class' => 'btn btn-info']);
		ActiveForm::end();
		Modal::end();
		?>
	</div>
</div>

