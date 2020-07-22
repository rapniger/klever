<?php

use yii\widgets\ListView;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Редактор библиотеки';
$hostInfoAPI = yii::$app->urlManagerAPI->hostInfo;

$map = ArrayHelper::map($book, 'id', 'title');

$js = <<<JS
    /*ФОРМА ОБНОВЛЕНИЯ*/
    jQuery(document).ready(function() {
        var UpdateForm = jQuery('#update-form');
        jQuery('body').on('click', '#update-form-button', function(e) {
            console.log(UpdateForm.serialize());
            e.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: "$hostInfoAPI/v1/library/update",
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

$this->registerJs( $js, $position = yii\web\View::POS_END, $key = null );
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
        <h4><b>Автор книги:</b> <a href="/author/<?= $library->slug?>.html"><?= $library->name.' '.$library->subname?></a></h4>
        <h4><b>Наименование книги:</b> <a href="/book/<?= $library->book[0]->slug ?? 'error'?>.html"><?= $library->book[0]->title ?? 'Не привязан'?></a></h4>
		<p><b>Издательский дом:</b> <?= $library->book[0]->publishing ?? 'Не привязан'?></p>
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
        echo $form->field($updateModel, 'id')->hiddenInput(['value' => $library->id, 'readonly' => true])->label(false);
        echo Html::button('Обновить', ['type' => 'submit', 'id' => 'update-form-button', 'class' => 'btn btn-info']);
		ActiveForm::end();
		Modal::end();
		?>
	</div>
</div>

