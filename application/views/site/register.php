<?php

use yii\bootstrap4\ActiveForm;

$this->title = 'Регистрация';
$js = <<<JS
    $( document ).ready(function() {
       var FormRegister = $('#register-form');
       $('body').on('click', '#register-button', function(e) {
           e.preventDefault();
           console.log("Передача на сервер");
           $.ajax({
                data: FormRegister.serialize(),
                type: 'POST',
                url: "/action/response-register.html",
                success: function(response) {
                    var Alert = $('.alert');
                    var Form = $('#guest-register');
                    var H4 = $('.alert h4.alert-heading');
                    var P = $('.alert p.alert-description')
                    switch (response.event) {
                        case 'Success-Register':
                            Form.fadeOut(150);
                            H4.text(response.message);
                            P.text(response.description);
                            Alert.addClass('alert-success').attr('data-event', 'open').fadeIn(200);
                            break;
                        case 'Error-Register':
                            H4.text(response.message);
                            P.text(response.description);
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
			<div class="col-12" style="margin-top: 40px">
                <div id="guest-register">
                    <h3 class="text-center">Регистрация</h3>
	                <?php $form = ActiveForm::begin([
		                'id' => 'register-form',
		                'enableAjaxValidation' => true,
		                'validationUrl' => '/validate.html',
	                ]);?>
	                <?= $form->field($model, 'username')->textInput(['placeholder' => 'Username'])->label(false)?>
	                <?= $form->field($model, 'email')->textInput(['placeholder' => 'E-mail'])->label(false)?>
	                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль'])->label(false)?>
	                <?= $form->field($model, 'PasswordRepeat')->passwordInput(['placeholder' => 'Повтор пароля'])->label(false)?>
                    <button type="submit" id="register-button" class="btn btn-primary">Зарегистрироваться</button>
	                <?php ActiveForm::end()?>
                </div>
                <div id="response-form-answer" style="margin-top: 1em;">
                    <div class="alert" data-event="close" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="alert-heading">
                        </h4>
                        <p class="alert-description mb-0">
                        </p>
                    </div>
                </div>
			</div>
		</div>
	</div>
</section>
