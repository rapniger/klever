<?php


namespace admin\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Author;
use common\models\Book;


class LibraryModel extends Model
{
	public $name;
	public $subname;
	public $idBook;
	public $slug;
	
	const SCENARIO_ADD_FORM = 'add-form';
	const SCENARIO_UPDATE_FORM = 'update-form';
	const SCENARIO_CHECK_SLUG = 'check-slug';
	
	public function rules()
	{
		return [
			[
				'slug',
				'string',
				'on' => self::SCENARIO_CHECK_SLUG
			],
			[
				['name', 'subname', 'idBook', 'slug'],
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
				['name', 'subname', 'idBook', 'slug'],
				'string',
				'on' => self::SCENARIO_UPDATE_FORM
			],
		];
	}
	
	public function scenarios()
	{
		return [
			self::SCENARIO_CHECK_SLUG => ['slug'],
			self::SCENARIO_ADD_FORM => ['name', 'subname', 'idBook', 'slug'],
			self::SCENARIO_UPDATE_FORM => ['name', 'subname', 'idBook', 'slug'],
		];
	}
	
	public function checkFieldUnique()
	{
		return Author::className();
	}
	
	public function findLibrarys()
	{
		return new ActiveDataProvider([
			'query' => (new Author())::find()->with('book'),
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
	
	public function findLibrary()
	{
		return Author::find()->where(['slug' => $this->slug])->with('book')->one();
	}
	
	public function findBooks()
	{
		return Book::find()->all();
	}
	
	public function findAuthors()
	{
		return Author::find()->all();
	}
}