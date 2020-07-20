<?php


namespace admin\models;


use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Book;
/**
 * Class Book
 * @package admin\models
 * @todo
 */
class BookModel extends Model
{
	public $name;
	public $slug;
	public $publishing;
	
	const SCENARIO_READ_FORM = 'read-form';
	const SCENARIO_ADD_FORM = 'add-form';
	const SCENARIO_UPDATE_FORM = 'update-form';
	const SCENARIO_DELETE_FORM = 'delete-form';
	
	public function rules()
	{
		return [
			[
				['name','slug', 'publishing'],
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
				['name','slug', 'publishing'],
				'string',
				'on' => self::SCENARIO_UPDATE_FORM
			],
		];
	}
	
	public function scenarios()
	{
		return [
			self::SCENARIO_ADD_FORM => ['name','slug', 'publishing'],
			self::SCENARIO_UPDATE_FORM => ['name','slug', 'publishing'],
		];
	}
	
	public function checkFieldUnique()
	{
		return Book::className();
	}
	
	public function findBooks()
	{
		return new ActiveDataProvider([
			'query' => (new Book())::find(),
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
	
	public function findBook()
	{
		return (new Book())::findOne(['slug' => $this->slug]);
	}
}