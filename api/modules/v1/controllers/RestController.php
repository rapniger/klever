<?php

namespace api\modules\v1\controllers;

use yii;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use admin\models\BookModel;
use admin\models\AuthorModel;

/**
 * Class RestController
 * @package api\modules\v1\controllers
 */
class RestController extends ActiveController
{
	/**
	 * @return array
	 * @todo ДОПИСАТЬ!!! Чтение документации. Контроль доступа.
	 */
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['contentNegotiator'] = [
			'formats' => [
				'application/json' => Response::FORMAT_JSON,
			],
		];
		return $behaviors;
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionBook()
	{
		return $this->getAction('readBook', 'admin\models\BookModel', BookModel::SCENARIO_DEFAULT);
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionBooks()
	{
		return $this->getAction('readBooks', 'admin\models\BookModel', BookModel::SCENARIO_DEFAULT);
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionCreateBook()
	{
		return $this->getAction('create', 'admin\models\BookModel', BookModel::SCENARIO_ADD_FORM);
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionUpdateBook()
	{
		return $this->getAction('update', 'admin\models\BookModel', BookModel::SCENARIO_UPDATE_FORM);
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionDeleteBook()
	{
		return $this->getAction('delete', 'admin\models\BookModel', BookModel::SCENARIO_DELETE_FORM);
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionAuthor()
	{
		return $this->getAction('readAuthor', 'admin\models\AuthorModel', AuthorModel::SCENARIO_DEFAULT);
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionAuthors()
	{
		return $this->getAction('readAuthors', 'admin\models\AuthorModel', AuthorModel::SCENARIO_DEFAULT);
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionCreateAuthor()
	{
		return $this->getAction('create', 'admin\models\AuthorModel', AuthorModel::SCENARIO_ADD_FORM);
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionUpdateAuthor()
	{
		return $this->getAction('update', 'admin\models\AuthorModel', AuthorModel::SCENARIO_UPDATE_FORM);
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionDeleteAuthor()
	{
		return $this->getAction('delete', 'admin\models\AuthorModel', AuthorModel::SCENARIO_DELETE_FORM);
	}
	
	/**
	 * @param $action - действие в модели
	 * @param $model - наименование модели
	 * @param $scenario - сценария для валидации формы
	 * @return yii\web\BadRequestHttpException
	 * @todo
	 */
	public function getAction($action, $model, $scenario)
	{
		$request = $this->getRequest();
		if(empty($request)){
			return (new yii\web\BadRequestHttpException('Ошибка запроса'));
		}
		if(class_exists($model) === true){
			$findModel = new $model($scenario);
			if($findModel->load($request, '')){
				return $findModel->$action();
			}
		}
		return (new yii\web\BadRequestHttpException('Ошибка запроса'));
	}
	
	/**
	 * @return array|mixed|null
	 */
	public function getRequest()
	{
		return  yii::$app->request->post() ?? yii::$app->request->get() ?? null;
	}
}
