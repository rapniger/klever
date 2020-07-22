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
class BookController extends ActiveController
{
	public $modelClass = '';
	public $enableCsrfValidation = false;
	/**
	 * @return array
	 * @todo ДОПИСАТЬ!!! Чтение документации. Контроль доступа.
	 */
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['corsFilter'] = [
			'class' => \yii\filters\Cors::className(),
			'cors' => [
				'Origin' => [Yii::$app->urlManager->hostInfo, Yii::$app->urlManagerApplication->hostInfo, Yii::$app->urlManagerAdmin->hostInfo],
				'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
				'Access-Control-Request-Headers' => ['*'],
				'Access-Control-Allow-Credentials' => true,
				'Access-Control-Max-Age' => 86400,
				'Access-Control-Expose-Headers' => [],
			],
		];
		$behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
		return $behaviors;
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionBook($slug)
	{
		return $this->getAction('readBook', 'admin\models\BookModel', BookModel::SCENARIO_READ_BOOK, ['slug' => $slug]);
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionBooks($page)
	{
		return $this->getAction('readBooks', 'admin\models\BookModel', BookModel::SCENARIO_READ_BOOKS, ['page' => $page]);
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
	 * @param $action
	 * @param $model
	 * @param $scenario
	 * @param null $params
	 * @return yii\web\BadRequestHttpException
	 */
	public function getAction($action, $model, $scenario, $params = null)
	{
		if(class_exists($model) === true){
			$findModel = new $model(['scenario' => $scenario]);
			$request = $this->getRequest($this->getClass($model));
			if(empty($params)){
				if($findModel->load($request, '')){
					if(method_exists($findModel, $action)){
						return $findModel->$action();
					}else{
						return (new yii\web\BadRequestHttpException('Ошибка запроса'));
					}
				}
			}else{
				if($findModel->load($params, '')){
					if(method_exists($findModel, $action)){
						return $findModel->$action();
					}else{
						return (new yii\web\BadRequestHttpException('Ошибка запроса'));
					}
				}
			}
		}
		return (new yii\web\BadRequestHttpException('Ошибка запроса'));
	}
	
	/**
	 * @return array|mixed|null
	 */
	public function getRequest($model)
	{
		if(yii::$app->request->post($model)){
			$post = yii::$app->request->post($model);
		}else{
			$post = yii::$app->request->post();
		}
		return $post ?? yii::$app->request->get() ?? null;
	}
	
	/**
	 * @param $params
	 * @return mixed
	 */
	public function getClass($params)
	{
		return end(explode('\\', $params));
	}
}
