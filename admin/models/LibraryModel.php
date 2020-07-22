<?php


namespace admin\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Author;
use common\models\Book;


class LibraryModel extends Model
{
	public $id;
	public $page;
	public $name;
	public $subname;
	public $idBook;
	public $slug;
	
	public $pagination;
	
	const SCENARIO_READ_LIBRARY = 'read-library';
	const SCENARIO_READ_LIBRARYS = 'read-librarys';
	const SCENARIO_ADD_FORM = 'add-form';
	const SCENARIO_UPDATE_FORM = 'update-form';
	const SCENARIO_CHECK_SLUG = 'check-slug';
	
	public function rules()
	{
		return [
			[
				'page',
				'integer',
				'on' => self::SCENARIO_READ_LIBRARYS
			],
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
				['id','idBook'],
				'integer',
				'on' => self::SCENARIO_UPDATE_FORM
			],
			[
				['name', 'subname', 'slug'],
				'string',
				'on' => self::SCENARIO_UPDATE_FORM
			],
		];
	}
	
	public function scenarios()
	{
		return [
			self::SCENARIO_READ_LIBRARY => ['slug'],
			self::SCENARIO_READ_LIBRARYS => ['page'],
			self::SCENARIO_CHECK_SLUG => ['slug'],
			self::SCENARIO_ADD_FORM => ['name', 'subname', 'idBook', 'slug'],
			self::SCENARIO_UPDATE_FORM => ['id', 'name', 'subname', 'idBook', 'slug'],
		];
	}
	
	public function checkFieldUnique()
	{
		return Author::className();
	}
	
	public function readLibrarys()
	{
		$query = (new Author())::find();
		$provider =  new ActiveDataProvider([
			'query' => $query->with('book'),
			'pagination' => [
				'pageSize' => 12,
				'totalCount' => $query->count(),
				'pageSizeParam' => false,
			],
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_ASC,
				]
			],
		]);
		$model = $provider->getModels();
		//return ['model' => $model];
		foreach ($model as $key => $value){
			if(!empty($value['book'])){
				$modelBook[$key] = $value['book'][0];
			}
		}
		$this->pagination = $provider;
		return ['author' => $model, 'book' => $modelBook, 'pagination' => $provider];
	}
	
	
	/**
	 * @return array|yii\db\ActiveRecord|null
	 * @throws yii\base\InvalidConfigException
	 */
	public function readLibrary()
	{
		$model = new Author();
		$table = $model::find()->where(['slug' => $this->slug])->with('book')->one();
		if(!$table){
			throw (new yii\base\InvalidConfigException());
		}
		$table->created_at = $this->getConvertDate($table->created_at);
		$table->updated_at = $this->getConvertDate($table->updated_at);
		return $table;
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
			$table->id_book = $this->idBook;
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
	
	/**
	 * @return array|yii\web\BadRequestHttpException
	 * @throws \Throwable
	 * @throws yii\db\StaleObjectException
	 * @throws yii\web\BadRequestHttpException
	 */
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
	
	public function findBooks()
	{
		return Book::find()->all();
	}
	
	public function findAuthors()
	{
		return Author::find()->all();
	}
}