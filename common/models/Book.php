<?php


namespace common\models;


use yii\db\ActiveRecord;

/**
 * Class Book
 * @package common\models
 */
class Book extends ActiveRecord
{
	const BOOK_STATUS_ACTIVE = 10;
	const BOOK_STATUS_INACTIVE = 9;
	const BOOK_STATUS_UNPUBLISHED = 5;
	const BOOK_STATUS_DELETE = 0;
	
	/**
	 * @return string
	 */
	public static function tableName()
	{
		return '{{%book}}';
	}
}