<?php

namespace api\modules\v1\controllers;

use yii;
use yii\rest\ActiveController;
use yii\web\Response;
use admin\models\LibraryModel;

/**
 * Class LibraryController
 * @package api\modules\v1\controllers
 */
class LibraryController extends ActiveController
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
	public function actionLibrary($slug)
	{
		return $this->getAction('readLibrary', 'admin\models\LibraryModel', LibraryModel::SCENARIO_READ_LIBRARY, ['slug' => $slug]);
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionLibrarys($page)
	{
		return $this->getAction('readLibrarys', 'admin\models\LibraryModel', LibraryModel::SCENARIO_READ_LIBRARYS, ['page' => $page]);
	}
	
	/**
	 * @return yii\web\BadRequestHttpException
	 */
	public function actionUpdateLibrary()
	{
		return $this->getAction('update', 'admin\models\LibraryModel', LibraryModel::SCENARIO_UPDATE_FORM);
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
