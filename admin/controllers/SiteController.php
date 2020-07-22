<?php
namespace admin\controllers;

use admin\models\PageModel;
use common\models\Author;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;
use common\models\User;
use admin\models\BookModel;
use admin\models\AuthorModel;
use admin\models\LibraryModel;
use admin\models\SlugModel;
use yii\web\NotFoundHttpException;

/**
 * Class SiteController
 * @package admin\controllers
 */
class SiteController extends Controller
{
	/**
	 * @return string|Response
	 */
	public function actionIndex()
    {
	    if(yii::$app->user->isGuest){
		    return $this->redirect(yii::$app->urlManagerApplication->HostInfo.'/signup.html');
	    }
        return $this->render('index');
    }
	
	/**
	 * @param $slug
	 * @return string|Response
	 * @throws BadRequestHttpException
	 * @throws NotFoundHttpException
	 * @throws \yii\base\InvalidConfigException
	 */
    public function actionBook($slug)
    {
	    if(yii::$app->user->isGuest){
		    return $this->redirect(yii::$app->urlManagerApplication->HostInfo.'/signup.html');
	    }
	    $getModel = new SlugModel();
	    if($getModel->load(['slug' => $slug], '') && $getModel->validate()){
		    $addModel = new BookModel(['scenario' => BookModel::SCENARIO_ADD_FORM]);
		    $updateModel = new BookModel(['scenario' => BookModel::SCENARIO_UPDATE_FORM]);
		    if($updateModel->load(['slug' => $slug], '')){
			    $book = $updateModel->readBook();
			    if(empty($book)){
				    throw new NotFoundHttpException('Страница не найдена!');
			    }
			    return $this->render('book',compact('updateModel', 'addModel', 'book'));
		    }
	    }
	    throw new BadRequestHttpException('Ошибка запроса');
    }
   
    public function actionBooks()
    {
	    if(yii::$app->user->isGuest){
		    return $this->redirect(yii::$app->urlManagerApplication->HostInfo.'/signup.html');
	    }
	    $get = yii::$app->request->get();
	    $getModel = new PageModel();
	    $model = new BookModel(['scenario' => BookModel::SCENARIO_ADD_FORM]);
	    if($getModel->load(['page' => $get['page'], 'PerPage' => $get['per-page']], '') && $getModel->validate()){
		    $provider = $model->readBooks();
		    return $this->render('books', compact('model', 'provider'));
	    }else{
	    	throw new BadRequestHttpException('Ошибка запроса!');
	    }
    }
	
	/**
	 * @param $slug
	 * @return string|Response
	 * @throws BadRequestHttpException
	 * @throws NotFoundHttpException
	 */
	public function actionAuthor($slug)
	{
		if(yii::$app->user->isGuest){
			return $this->redirect(yii::$app->urlManagerApplication->HostInfo.'/signup.html');
		}
		$getModel = new SlugModel();
		if($getModel->load(['slug' => $slug], '') && $getModel->validate()){
			$addModel = new AuthorModel(['scenario' => AuthorModel::SCENARIO_ADD_FORM]);
			$updateModel = new AuthorModel(['scenario' => AuthorModel::SCENARIO_UPDATE_FORM]);
			if($updateModel->load(['slug' => $slug], '')){
				$author = $updateModel->readAuthor();
				if(empty($author)){
					throw new NotFoundHttpException('Страница не найдена!');
				}
				return $this->render('author',compact('updateModel', 'addModel', 'author'));
			}
		}
		throw new BadRequestHttpException('Ошибка запроса');
	}
	
	/**
	 * @return string|Response
	 * @throws BadRequestHttpException
	 */
	public function actionAuthors()
	{
		if(yii::$app->user->isGuest){
			return $this->redirect(yii::$app->urlManagerApplication->HostInfo.'/signup.html');
		}
		$get = yii::$app->request->get();
		$getModel = new PageModel();
		$model = new AuthorModel(['scenario' => AuthorModel::SCENARIO_ADD_FORM]);
		if($getModel->load(['page' => $get['page'], 'PerPage' => $get['per-page']], '') && $getModel->validate()){
			$provider = $model->readAuthors();
			return $this->render('authors', compact('model', 'provider'));
		}else{
			throw new BadRequestHttpException('Ошибка запроса!');
		}
	}
	
	/**
	 * @param $slug
	 * @return string|Response
	 * @throws BadRequestHttpException
	 * @throws NotFoundHttpException
	 * @throws \yii\base\InvalidConfigException
	 */
	public function actionLibrary($slug)
	{
		if(yii::$app->user->isGuest){
			return $this->redirect(yii::$app->urlManagerApplication->HostInfo.'/signup.html');
		}
		$getModel = new SlugModel();
		if($getModel->load(['slug' => $slug], '') && $getModel->validate()){
			$checkModel = new LibraryModel(['scenario' => LibraryModel::SCENARIO_CHECK_SLUG]);
			$updateModel = new LibraryModel(['scenario' => LibraryModel::SCENARIO_UPDATE_FORM]);
			if($checkModel->load(['slug' => $slug], '')){
				$library = $checkModel->readLibrary();
				$book = $checkModel->findBooks();
				$author = $checkModel->findAuthors();
				if(empty($library)){
					throw new NotFoundHttpException('Страница не найдена!');
				}
				return $this->render('library',compact('updateModel','library', 'book', 'author'));
			}
		}
		throw new BadRequestHttpException('Ошибка запроса');
	}
	
	/**
	 * @return string|Response
	 * @throws BadRequestHttpException
	 */
	public function actionLibrarys()
	{
		if(yii::$app->user->isGuest){
			return $this->redirect(yii::$app->urlManagerApplication->HostInfo.'/signup.html');
		}
		$get = yii::$app->request->get();
		$getModel = new PageModel();
		$model = new LibraryModel(['scenario' => LibraryModel::SCENARIO_ADD_FORM]);
		if($getModel->load(['page' => $get['page'], 'PerPage' => $get['per-page']], '') && $getModel->validate()){
			$provider = $model->readLibrarys();
			return $this->render('librarys', compact('model', 'provider'));
		}else{
			throw new BadRequestHttpException('Ошибка запроса!');
		}
	}
	
	/**
	 * @return string|Response
	 */
	public function actionProfile()
	{
		if(yii::$app->user->isGuest){
			return $this->redirect(yii::$app->urlManagerApplication->HostInfo.'/signup.html');
		}
		return $this->render('profile');
	}
	
	/**
	 * @return \yii\web\Response
	 */
	public function actionLogout()
	{
		if(yii::$app->user->isGuest){
			return $this->redirect(yii::$app->urlManagerApplication->HostInfo.'/signup.html');
		}
		Yii::$app->user->logout();
		return $this->redirect(yii::$app->urlManagerApplication->HostInfo);
	}
	
	/**
	 * @return string
	 */
	public function actionError()
	{
		$exception = [
			'status' => Yii::$app->errorHandler->exception->statusCode,
			'message' => Yii::$app->errorHandler->exception->getMessage(),
		];
		return $this->render('error', compact('exception'));
	}
	
	/**
	 * @return array
	 */
	public function actionValidate()
	{
		$post = Yii::$app->request->post();
		if(!is_null($post['BookModel'])){
			switch ($post['ajax']){
				case 'add-form':
					$model = new BookModel(['scenario' => BookModel::SCENARIO_ADD_FORM]);
					break;
				case 'update-form':
					$model = new BookModel(['scenario' => BookModel::SCENARIO_UPDATE_FORM]);
					break;
				default:
					$model = '';
			}
		}
		if(!is_null($post['AuthorModel'])){
			switch ($post['ajax']){
				case 'add-form':
					$model = new BookModel(['scenario' => AuthorModel::SCENARIO_ADD_FORM]);
					break;
				case 'update-form':
					$model = new BookModel(['scenario' => AuthorModel::SCENARIO_UPDATE_FORM]);
					break;
				default:
					$model = '';
			}
		}
		if(!is_null($post['LibraryModel'])){
			switch ($post['ajax']){
				case 'add-form':
					$model = new LibraryModel(['scenario' => LibraryModel::SCENARIO_ADD_FORM]);
					break;
				case 'update-form':
					$model = new LibraryModel(['scenario' => LibraryModel::SCENARIO_UPDATE_FORM]);
					break;
				case 'check-slug':
					$model = new LibraryModel(['scenario' => LibraryModel::SCENARIO_CHECK_SLUG]);
					break;
				default:
					$model = '';
			}
		}
		if(is_null($post)){
			$model = '';
		}
		if(Yii::$app->request->isAjax && $model->load($post)){
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
	}
}
