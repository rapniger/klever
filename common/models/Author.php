<?php


namespace common\models;


use yii\db\ActiveRecord;

/**
 * Class Author
 * @package common\models
 */
class Author extends ActiveRecord
{
	const AUTHOR_STATUS_ACTIVE = 10;
	const AUTHOR_STATUS_INACTIVE = 9;
	const AUTHOR_STATUS_UNPUBLISHED = 5;
	const AUTHOR_STATUS_DELETE = 0;
	
	/**
	 * @return string
	 */
	public static function tableName()
	{
		return '{{%author}}';
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getBook()
	{
		return $this->hasOne(Book::className(), ['id' => 'id_book']);
	}
}