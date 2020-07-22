<?php

use yii\widgets\LinkPager;

$this->title = 'Редактор библиотеки';

$hostInfoAPI = yii::$app->urlManagerAPI->hostInfo;
$currentPage = yii::$app->request->get('page');
if(empty($currentPage)){
	$currentPage = 1;
}
$js = <<<JS
	jQuery(document).ready(function() {
		jQuery.ajax({
    		type: "GET",
    		url: "$hostInfoAPI/v1/library/readLibrarys/$currentPage",
    		success: function(res){
    		    var table = jQuery('#admin-librarys-items');
    		    var i = 0;
    		    var max = res['author'].length;
    		    for(i; i < max; i++){
    		        if(res['book'][i] != undefined){
    		            table.append('<tr><th>'+res['author'][i]['id']+'</th><th>'+res['author'][i]['name']+' '+res['author'][i]['subname']+'</th><th>'+res['book'][i]['title']+'</th><th>12</th><th><a href="/library/'+res['author'][i]['slug']+'.html"><i class="fa fa-2x fa-edit"></i></a></th></tr>');
    		        }else{
    		            table.append('<tr><th>'+res['author'][i]['id']+'</th><th>'+res['author'][i]['name']+' '+res['author'][i]['subname']+'</th><th>Не привязан</th><th>Не привязан</th><th><a href="/library/'+res['author'][i]['slug']+'.html"><i class="fa fa-2x fa-edit"></i></a></th></tr>');
    		        }
    		    }
    		    if(res.statusCode == 400){
    		        table.append('Ошибка запроса');
    		    }
    		}
		});
		return false;
	});
JS;

$this->registerJs( $js, $position = yii\web\View::POS_END, $key = null );
?>

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
					<tbody id="admin-librarys-items">
					
					</tbody>
				</table>
			</div>
			<div class='card-footer clearfix'>
				<?= LinkPager::widget([
					'pagination' => $provider['pagination']->pagination,
				]);
				?>
			</div>
		</div>
	</div>
</div>
