<?php

use yii\widgets\ListView;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Редактор книг';
$hostInfoAPI = yii::$app->urlManagerAPI->hostInfo;


$js = <<<JS
    /*ФОРМА ДОБАВЛЕНИЯ*/
    jQuery(document).ready(function() {
        var AddForm = jQuery('#add-form');
        jQuery('body').on('click', '#add-form-button', function(e) {
            e.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: "$hostInfoAPI/v1/book/create",
                data: AddForm.serialize(),
                success: function(res) {
                    if(res.status == true){
                        location.reload();
                    }
                }
            })
        })
        return false;
    });
JS;
$js1 = <<<JS
    /*ФОРМА ОБНОВЛЕНИЯ*/
    jQuery(document).ready(function() {
        var UpdateForm = jQuery('#update-form');
        jQuery('body').on('click', '#update-form-button', function(e) {
            console.log(UpdateForm.serialize());
            e.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: "$hostInfoAPI/v1/book/update",
                data: UpdateForm.serialize(),
                success: function(res) {
                    if(res.status == true){
                        location.reload();
                    }
                }
            })
        })
        return false;
    });
JS;
$js2 = <<<JS
    /*ФОРМА УДАЛЕНИЯ*/
    jQuery(document).ready(function() {
        jQuery('body').on('click', '#delete-form-button', function(e) {
            var AttributeID = jQuery(this).attr('data-id');
            e.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: "$hostInfoAPI/v1/book/delete",
                data: {id: AttributeID},
                success: function(res) {
                    if(res.status == true){
                        window.location.replace("/books.html");
                    }
                }
            })
        })
        return false;
    });
JS;

$this->registerJs( $js, $position = yii\web\View::POS_END, $key = null );
$this->registerJs( $js1, $position = yii\web\View::POS_END, $key = null );
$this->registerJs( $js2, $position = yii\web\View::POS_END, $key = null );


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
    echo Html::button('Сохранить', ['type' => 'submit', 'id' => 'add-form-button', 'class' => 'btn btn-info']);
ActiveForm::end();
Modal::end();
?>
<div class="row" style="margin-top: 40px;">
    <div class="col-md-12" style="margin: 20px 0px">
        <a class="btn btn-primary" href='/books.html'>
            Вернуться
        </a>
        <a id="delete-form-button" class="btn btn-danger" data-id="<?= $book->id?>">
            Удалить
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
            echo $form->field($updateModel, 'slug')->textInput(['value' => $book->slug,'placeholder' => 'Ссылка', 'readonly' => true])->label(false);
            echo $form->field($updateModel, 'publishing')->textInput(['value' => $book->publishing,'placeholder' => 'Издательский дом'])->label(false);
            echo $form->field($updateModel, 'id')->hiddenInput(['value' => $book->id, 'readonly' => true])->label(false);
            echo Html::button('Обновить', ['type' => 'submit', 'id' => 'update-form-button', 'class' => 'btn btn-info']);
            ActiveForm::end();
        Modal::end();
        ?>
	</div>
</div>

