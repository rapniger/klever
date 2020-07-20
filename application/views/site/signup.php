<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\View;

$this->title = 'Авторизация';
$js = <<<JS
    $( document ).ready(function() {
       var FormSignup = $('#signup-form');
       $('body').on('click', '#signup-button', function(e) {
           e.preventDefault();
           $.ajax({
                data: FormSignup.serialize(),
                type: 'POST',
                url: "/action/response-signup.html",
                success: function(response) {
                    var Alert = $('.alert');
                    var Form = $('#guest-signup');
                    var H4 = $('.alert h4.alert-heading');
                    var P = $('.alert p.alert-description')
                    switch (response.event) {
                        case 'Success-Signup':
                            Form.fadeOut(150);
                            H4.text(response.message);
                            Alert.addClass('alert-success').attr('data-event', 'open').fadeIn(200);
                            break;
                        case 'Error-Signup':
                            H4.text(response.message);
                            Alert.addClass('alert-warning').attr('data-event', 'open').fadeIn(200);
                            break;
                    }
                }
           });
           return false;
       })
    });
JS;
$this->registerJs( $js, $position = yii\web\View::POS_END, $key = null );
?>
<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-12" style="margin-top: 40px;">
				<div id="guest-signup">
					<h3 class="text-center">
						Авторизация
					</h3>
					<?php $form = ActiveForm::begin([
						'id' => 'signup-form',
						'action' => false,
						'enableAjaxValidation' => true,
						'validationUrl' => '/validate.html',
					]); ?>
					
					<?= $form->field($model, 'username')->textInput(['placeholder' => 'Username'])->label(false) ?>
					
					<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль'])->label(false) ?>
					
					<?= $form->field($model, 'RememberMe')->checkbox([
						'template' => "<div class=\"col-lg-offset-1 col-lg-11\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
					])->label('Запомнить меня?') ?>
					<button type="submit" id="signup-button" class="btn btn-primary">
						Войти
					</button>
					<?php ActiveForm::end(); ?>
				</div>
				<div id="ajax-response">
					<div class="alert" data-event="close" role="alert" style="display: none;">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="alert-heading">
						</h4>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
