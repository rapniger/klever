<?php

namespace admin\models;

use yii\base\Model;

/**
 * Class PageModel
 * @package admin\models
 */
class PageModel extends Model
{
	/**
	 * @var $page
	 */
	public $page;
	public $PerPage;
	
	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			[
				['page', 'PerPage'],
				'integer'
			]
		];
	}
}