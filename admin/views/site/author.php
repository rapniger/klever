<?php

use yii\widgets\ListView;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Редактор автора';
$hostInfoAPI = yii::$app->urlManagerAPI->hostInfo;

$js = <<<JS
    /*ФОРМА ДОБАВЛЕНИЯ*/
    jQuery(document).ready(function() {
        var AddForm = jQuery('#add-form');
        jQuery('body').on('click', '#add-form-button', function(e) {
            e.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: "$hostInfoAPI/v1/author/create",
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
            e.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: "$hostInfoAPI/v1/author/update",
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
                url: "$hostInfoAPI/v1/author/delete",
                data: {id: AttributeID},
                success: function(res) {
                    if(res.status == true){
                        window.location.replace("/authors.html");
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
	'toggleButton' => ['label' => 'Добавить автора', 'class' => 'btn btn-primary'],
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
echo Html::button('Сохранить', ['type' => 'submit', 'id' => 'add-form-button', 'class' => 'btn btn-info']);
ActiveForm::end();
Modal::end();
?>
<div class="row" style="margin-top: 40px;">
	<div class="col-md-12" style="margin: 20px 0px">
		<a class="btn btn-primary" href='/authors.html'>
			Вернуться
		</a>
        <a id="delete-form-button" class="btn btn-danger" data-id="<?= $author->id?>">
            Удалить
        </a>
	</div>
	<div class="col-md-3">
		<img src="https://www.clipartmax.com/png/middle/171-1717870_stockvader-predicted-cron-for-may-user-profile-icon-png.png" height="90%" width="90%" />
	</div>
	<div class="col-md-9">
		<h4><b>Имя автора:</b> <?= $author->name?></h4>
		<h4><b>Фамилия автора:</b> <?= $author->subname?></h4>
		<p><b>Ссылка автора:</b> <?= $author->slug?></p>
		<?php
		Modal::begin([
			'id' => 'update-book',
			'header' => '<h4>Форма редактирования</h4>',
			'toggleButton' => ['label' => 'Обновить автора', 'class' => 'btn btn-info'],
		]);
		$form = ActiveForm::begin([
			'id' => 'update-form',
			'action' => false,
			'enableAjaxValidation' => true,
			'validationUrl' => '/validate.html',
		]);
		echo $form->field($updateModel, 'name')->textInput(['value' => $author->name,'placeholder' => 'Имя автора'])->label(false);
		echo $form->field($updateModel, 'subname')->textInput(['value' => $author->subname,'placeholder' => 'Фамилия автора'])->label(false);
		echo $form->field($updateModel, 'slug')->textInput(['value' => $author->slug,'placeholder' => 'Ссылка', 'readonly' => true])->label(false);
		echo $form->field($updateModel, 'id')->hiddenInput(['value' => $author->id, 'readonly' => true])->label(false);
		echo Html::button('Обновить', ['type' => 'submit', 'id' => 'update-form-button', 'class' => 'btn btn-info']);
		ActiveForm::end();
		Modal::end();
		?>
	</div>
</div>

