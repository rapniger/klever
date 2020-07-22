<?php

namespace api\modules\v1\controllers;

use yii;
use yii\rest\ActiveController;
use yii\web\Response;
use admin\models\AuthorModel;
use common\models\Author;

/**
 * Class RestController
 * @package api\modules\v1\controllers
 * @todo ДОПИСАТЬ КНИГУ. ДОПИСАТЬ БИБЛИОТЕКУ. ПЕРЕСМОТРЕТЬ DELETE в ЗАГОЛОВКЕ!
 * @todo ДОБАВИТЬ ТОКЕН! ЭТО ВАЖНО! В ЧАТЕ СПРОСИТЬ, КАК ПРАВИЛЬНО СДЕЛАТЬ.
 */
class AuthorController extends ActiveController
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
			/*'actions' => [
					'Origin' => [Yii::$app->urlManager->hostInfo, Yii::$app->urlManagerApplication->hostInfo, Yii::$app->urlManagerAdmin->hostInfo],
					'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
					'Access-Control-Request-Headers' => ['*'],
					'Access-Control-Allow-Credentials' => true,
					'Access-Control-Max-Age' => 86400,
				
			],*/
		];
		$behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
		return $behaviors;
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionAuthor($slug)
	{
		return $this->getAction('readAuthor', 'admin\models\AuthorModel', AuthorModel::SCENARIO_READ_AUTHOR, ['slug' => $slug]);
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionAuthors($page)
	{
		return $this->getAction('readAuthors', 'admin\models\AuthorModel', AuthorModel::SCENARIO_READ_AUTHORS, ['page' => $page]);
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
