<?php

use yii\widgets\ListView;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Редактор книг';

Modal::begin([
    'id' => 'add-book',
	'header' => '<h4>Форма добавления</h4>',
	'toggleButton' => ['label' => 'Добавить книгу', 'class' => 'btn btn-primary'],
]);
$form = ActiveForm::begin([
	'id' => 'add-form',
	'action' => false,
	'enableAjaxValidation' => true,
	'validationUrl' => '/validate.html',
]);
    echo $form->field($addModel, 'name')->textInput(['placeholder' => 'Наименование книги'])->label(false);
    echo $form->field($addModel, 'slug')->textInput(['placeholder' => 'Ссылка'])->label(false);
    echo $form->field($addModel, 'publishing')->textInput(['placeholder' => 'Издательский дом'])->label(false);
    echo Html::button('Сохранить', ['class' => 'btn btn-info']);
ActiveForm::end();
Modal::end();
?>
<div class="row" style="margin-top: 40px;">
    <div class="col-md-12" style="margin: 20px 0px">
        <a class="btn btn-primary" href='/books.html'>
            Вернуться
        </a>
    </div>
	<div class="col-md-3">
		<img src="https://c7.hotpng.com/preview/939/991/695/download-book-rectangle-books-png-image-thumbnail.jpg" height="90%" width="90%" />
	</div>
	<div class="col-md-9">
        <h4><b>Наименование книги:</b> <?= $book->title?></h4>
		<p><b>Ссылка на книгу:</b> <?= $book->slug?></p>
        <p><b>Издательский дом:</b> <?= $book->publishing?></p>
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
            echo $form->field($updateModel, 'name')->textInput(['value' => $book->title,'placeholder' => 'Наименование книги'])->label(false);
            echo $form->field($updateModel, 'slug')->textInput(['value' => $book->slug,'placeholder' => 'Ссылка', 'disabled' => true])->label(false);
            echo $form->field($updateModel, 'publishing')->textInput(['value' => $book->publishing,'placeholder' => 'Издательский дом'])->label(false);
            echo Html::button('Обновить', ['class' => 'btn btn-info']);
            ActiveForm::end();
        Modal::end();
        ?>
	</div>
</div>

