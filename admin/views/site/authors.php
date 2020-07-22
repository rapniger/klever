<?php

use yii\widgets\ListView;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Редактор авторов';
$hostInfoAPI = yii::$app->urlManagerAPI->hostInfo;
$currentPage = yii::$app->request->get('page');
if(empty($currentPage)){
    $currentPage = 1;
}
$js = <<<JS
	jQuery(document).ready(function() {
		jQuery.ajax({
    		type: "GET",
    		url: "$hostInfoAPI/v1/author/readAuthors/$currentPage",
    		data: {page: '1'},
    		success: function(res){
    		    var table = jQuery('#admin-authors-items');
    		    var i = 0;
    		    var max = res.length;
    		    for(i; i < max; i++){
    		        table.append('<tr><th>'+res[i]['id']+'</th><th>'+res[i]['name']+'</th><th>'+res[i]['subname']+'</th><th><a href="/author/'+res[i]['slug']+'.html"><i class="fa fa-2x fa-edit"></i></a></th></tr>');
    		    }
    		    if(res.statusCode == 400){
    		        table.append('Ошибка запроса');
    		    }
    		}
		});
		return false;
	});
JS;
$js1 = <<<JS
    jQuery(document).ready(function() {
        var AddForm = jQuery('#add-form');
        var AddButton = jQuery('#add-form-button');
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

$this->registerJs( $js, $position = yii\web\View::POS_END, $key = null );
$this->registerJs( $js1, $position = yii\web\View::POS_END, $key = null );

Modal::begin([
	'header' => '<h4>Форма добавления</h4>',
	'toggleButton' => ['label' => 'Добавить автора', 'class' => 'btn btn-primary'],
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
echo Html::button('Сохранить', ['type' => 'submit', 'id' => 'add-form-button', 'class' => 'btn btn-info']);
ActiveForm::end();
Modal::end();
?>
<div id="admin-authors">
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
                            <th>Имя автора</th>
                            <th>Фамилия автора</th>
                            <th style='width: 80px'>Действия</th>
                        </tr>
                        </thead>
                        <tbody id="admin-authors-items">
                        
                        </tbody>
                    </table>
                </div>
                <div class='card-footer clearfix'>
                    <?php
                    echo LinkPager::widget([
	                    'pagination' => $provider->pagination,
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
