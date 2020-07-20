<?php


namespace admin\models;


use yii\base\Model;

class SlugModel extends Model
{
	public $slug;
	
	public function rules()
	{
		return [
			[
				'slug',
				'string'
			]
		];
	}
}