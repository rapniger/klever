<?php


namespace admin\models;

use common\models\Book;
use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Author;

/**
 * Class Author
 * @package admin\models
 * @todo
 */
class AuthorModel extends Model
{
	public $slug;
	public $name;
	public $subname;

	const SCENARIO_READ_FORM = 'read-form';
	const SCENARIO_ADD_FORM = 'add-form';
	const SCENARIO_UPDATE_FORM = 'update-form';
	const SCENARIO_DELETE_FORM = 'delete-form';
	
	public function rules()
	{
		return [
			[
				['name','subname', 'slug'],
				'string',
				'on' => self::SCENARIO_ADD_FORM
			],
			[
				'slug',
				'unique',
				'targetClass' => $this->checkFieldUnique(),
				'message' => 'Эта ссылка занята!',
				'on' => self::SCENARIO_ADD_FORM
			],
			[
				['name','subname', 'slug'],
				'string',
				'on' => self::SCENARIO_UPDATE_FORM
			],
		];
	}
	
	public function scenarios()
	{
		return [
			self::SCENARIO_ADD_FORM => ['name','subname', 'slug'],
			self::SCENARIO_UPDATE_FORM => ['name','subname', 'slug'],
		];
	}
	
	public function checkFieldUnique()
	{
		return Book::className();
	}
	
	public function findAuthors()
	{
		return new ActiveDataProvider([
			'query' => (new Author())::find(),
			'pagination' => [
				'pageSize' => 12,
			],
			'sort' => [
				'defaultOrder' => [
					'updated_at' => SORT_DESC,
				]
			],
		]);
	}
	
	public function findAuthor()
	{
		return (new Author())::findOne(['slug' => $this->slug]);
	}
}