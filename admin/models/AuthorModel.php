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
	/**
	 * @var
	 */
	public $id;
	public $slug;
	public $page;
	public $name;
	public $subname;
	
	const SCENARIO_READ_AUTHOR = 'read-author';
	const SCENARIO_READ_AUTHORS = 'read-authors';
	const SCENARIO_ADD_FORM = 'add-form';
	const SCENARIO_UPDATE_FORM = 'update-form';
	const SCENARIO_DELETE_FORM = 'delete-form';
	
	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			[
				'slug',
				'string',
				'on' => self::SCENARIO_READ_AUTHOR
			],
			[
				'page',
				'integer',
				'on' => self::SCENARIO_READ_AUTHORS
			],
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
				'id',
				'integer',
				'on' => self::SCENARIO_UPDATE_FORM
			],
			[
				['name','subname', 'slug'],
				'string',
				'on' => self::SCENARIO_UPDATE_FORM
			],
			[
				'id',
				'integer',
				'on' => self::SCENARIO_DELETE_FORM
			]
		];
	}
	
	/**
	 * @return array
	 */
	public function scenarios()
	{
		return [
			self::SCENARIO_READ_AUTHOR => ['slug'],
			self::SCENARIO_READ_AUTHORS => ['page'],
			self::SCENARIO_ADD_FORM => ['name','subname', 'slug'],
			self::SCENARIO_UPDATE_FORM => ['id','name','subname', 'slug'],
			self::SCENARIO_DELETE_FORM => ['id'],
		];
	}
	
	/**
	 * @return string
	 */
	public function checkFieldUnique()
	{
		return Book::className();
	}
	
	/**
	 * @return ActiveDataProvider
	 */
	public function readAuthors()
	{
		$query = (new Author())::find();
		return new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 12,
				'totalCount' => $query->count(),
				'pageSizeParam' => false,
			],
			'sort' => [
				'defaultOrder' => [
					'updated_at' => SORT_ASC,
				]
			],
		]);
	}
	
	/**
	 * @return Author|null
	 * @throws yii\base\InvalidConfigException
	 */
	public function readAuthor()
	{
		$table = Author::findOne(['slug' => $this->slug]);
		if(!$table){
			throw (new yii\base\InvalidConfigException());
		}
		$table->created_at = $this->getConvertDate($table->created_at);
		$table->updated_at = $this->getConvertDate($table->updated_at);
		return $table;
	}
	
	/**
	 * @return array|yii\web\BadRequestHttpException
	 */
	public function create()
	{
		$date = date('Y:m:d H:i:s');
		if($this->validate()){
			$table = new Author();
			$table->name = $this->name;
			$table->subname = $this->subname;
			$table->slug = $this->slug;
			$table->status = 10;
			$table->created_at = strtotime($date);
			$table->updated_at = strtotime($date);
			if($table->save()){
				return ['status' => true, 'message' => 'Успешно добавлено!'];
			}
		}
		return (new yii\web\BadRequestHttpException('Ошибка запроса'));
	}
	
	/**
	 * @return array|yii\web\BadRequestHttpException
	 * @throws yii\web\BadRequestHttpException
	 */
	public function update()
	{
		$date = date('Y:m:d H:i:s');
		if($this->validate()){
			$table = Author::findOne($this->id);
			if(!$table){
				throw  (new yii\web\BadRequestHttpException('Ошибка запроса'));
			}
			$table->name = $this->name;
			$table->subname = $this->subname;
			$table->slug = $this->slug;
			$table->updated_at = strtotime($date);
			if($table->save()){
				return ['status' => true, 'message' => 'Успешно добавлено!'];
			}
		}
		return (new yii\web\BadRequestHttpException('Ошибка запроса'));
	}
	
	public function delete()
	{
		if($this->validate()) {
			$table = Author::findOne($this->id);
			if(!$table){
				throw  (new yii\web\BadRequestHttpException('Ошибка запроса'));
			}
			if($table->delete()){
				return ['status' => true, 'message' => 'Удаление успешно'];
			}
		}
		return (new yii\web\BadRequestHttpException('Ошибка запроса'));
	}
	
	/**
	 * @param $params
	 * @return string
	 * @throws yii\base\InvalidConfigException
	 */
	public function getConvertDate($params)
	{
		return yii::$app->formatter->asDate($params);
	}
	
}