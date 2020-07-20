<?php


namespace application\models;

use yii;
use yii\base\Model;
use common\models\User;

class SignupForm extends Model
{
	public $username;
	public $password;
	public $RememberMe = false;
	
	private $_user = false;
	
	public function rules()
	{
		return [
			[
				['username', 'password'],
				'required',
				'message' => 'Это обязательное поле!'
			],
			[
				'RememberMe',
				'boolean'
			],
		];
	}
	
	public function getLogin()
	{
		if($this->attributes['RememberMe'] == 0){
			$this->attributes['RememberMe'] = false;
		}else if($this->attributes['RememberMe'] == 1){
			$this->attributes['RememberMe'] = true;
		}
		return Yii::$app->user->login($this->getUser(), $this->RememberMe ? 3600*24*30 : 0);
	}

	public function getUser()
	{
		if($this->validate()){
			if ($this->_user === false) {
				$user = User::findOne(['username' => $this->username, 'status' => User::STATUS_ACTIVE]);
				if($user->validatePassword($this->password)){
					return $user;
				}
			}
		}
		return $this->_user;
	}
}