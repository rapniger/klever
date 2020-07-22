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
	/**
	 * @var
	 */
	public $id;
	public $page;
	public $name;
	public $slug;
	public $publishing;
	
	const SCENARIO_READ_BOOK = 'read-book';
	const SCENARIO_READ_BOOKS = 'read-books';
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
				'integer',
				'on' => self::SCENARIO_READ_BOOK
			],
			[
				'page',
				'integer',
				'on' => self::SCENARIO_READ_BOOKS
			],
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
				'id',
				'integer',
				'on' => self::SCENARIO_UPDATE_FORM
			],
			[
				['name','slug', 'publishing'],
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
			self::SCENARIO_READ_BOOK => ['slug'],
			self::SCENARIO_READ_BOOKS => ['page'],
			self::SCENARIO_ADD_FORM => ['name', 'slug', 'publishing'],
			self::SCENARIO_UPDATE_FORM => ['id', 'name', 'slug', 'publishing'],
			self::SCENARIO_DELETE_FORM => ['id']
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
	public function readBooks()
	{
		$query = (new Book())::find();
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
	 * @return Book|null
	 * @throws yii\base\InvalidConfigException
	 */
	public function readBook()
	{
		$table = Book::findOne(['slug' => $this->slug]);
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
			$table = new Book();
			$table->title = $this->name;
			$table->publishing = $this->publishing;
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
			$table = Book::findOne($this->id);
			if(!$table){
				throw  (new yii\web\BadRequestHttpException('Ошибка запроса'));
			}
			$table->title = $this->name;
			$table->publishing = $this->publishing;
			$table->slug = $this->slug;
			$table->updated_at = strtotime($date);
			if($table->save()){
				return ['status' => true, 'message' => 'Успешно обновлено!'];
			}
		}
		return (new yii\web\BadRequestHttpException('Ошибка запроса'));
	}
	
	/**
	 * @return array|yii\web\BadRequestHttpException
	 * @throws \Throwable
	 * @throws yii\db\StaleObjectException
	 * @throws yii\web\BadRequestHttpException
	 */
	public function delete()
	{
		if($this->validate()) {
			$table = Book::findOne($this->id);
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