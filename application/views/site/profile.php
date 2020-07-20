<?php

$user = yii::$app->user->identity;

?>
<section>
	<div class="container">
		<div class="row">
			<div class="col-12" style="margin: 40px 0px;">
				<h3>Профиль пользователя</h3>
			</div>
			<div class="col-3"style="border-right: 1px solid #333;">
				<p><b>USER:</b> <?= $user->username?></p>
			</div>
			<div class="col-9">
				<p>Информация</p>
			</div>
		</div>
	</div>
</section>
