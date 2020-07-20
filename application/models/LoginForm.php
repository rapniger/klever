<?php

namespace application\models;

use yii;
use yii\base\Model;
use common\models\User;

class LoginForm extends Model
{
	public $username;
	public $password;
	public $PasswordRepeat;
	public $email;
	
	public function rules()
	{
		return [
			[
				[
					'username',
					'password',
					'PasswordRepeat',
					'email'
				],
				'required',
				'message' => 'Это обязательное поле!'
			],
			[
				'username',
				'unique',
				'targetClass' => $this->checkFieldUnique(),
				'message' => 'Этот пользователь занят!'
			],
			[
				'email',
				'unique',
				'targetClass' => $this->checkFieldUnique(),
				'message' => 'Этот email занят!'
			],
			[
				'password',
				'string',
				'min' => 6,
				'max' => 255,
				'message' => 'Минимальное количество символов от 6 и выше'
			],
			[
				'PasswordRepeat',
				'string',
				'min' => 6,
				'max' => 255
			],
			[
				'PasswordRepeat',
				'compare',
				'compareAttribute'=>'password',
				'message' => 'Пароли не совпадают'
			],
		];
	}
	
	public function checkFieldUnique()
	{
		return User::className();
	}
	
	public function getSave()
	{
		if($this->validate()){
			$table = new User();
			$table->username = $this->username;
			$table->auth_key = Yii::$app->security->generateRandomString();
			$table->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
			$table->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
			$table->email = $this->email;
			$table->status = $table::STATUS_ACTIVE;
			$table->created_at = date("Y-m-d H:i:s");
			$table->updated_at = date("Y-m-d H:i:s");
			if($table->save()){
				return true;
			}
		}
		return false;
	}
}