<?php
namespace application\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\bootstrap4\ActiveForm;
use application\models\LoginForm;
use application\models\SignupForm;

/**
 * Class SiteController
 * @package application\controllers
 */
class SiteController extends Controller
{
	/**
	 * @return array
	 */
/*    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
*/
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
	 * @return string
	 */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
	/**
	 * @return \yii\web\Response
	 */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
	/**
	 * @return string|Response
	 */
	public function actionRegister()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$model = new LoginForm();
		return $this->render('register', compact('model'));
	}
	
	/**
	 * @return array|string
	 */
	public function actionResponseRegister()
	{
		if(yii::$app->request->isAjax){
			Yii::$app->response->format = Response::FORMAT_JSON;
			$model = new LoginForm();
			if($model->load(yii::$app->request->post()) && $model->getSave()){
				return ['code' => '201', 'event' => 'Success-Register', 'message' => 'Вы успешно зарегистрировались!', 'description' => 'Вы можете войти в систему!'];
			}else{
				return ['code' => '205', 'event' => 'Error-Register', 'message' => 'Ошибка регистрации!', 'description' => 'Неизвестная ошибка 2'];
			}
		}
		return $this->returnException();
	}
	
	/**
	 * @return string|Response
	 */
    public function actionSignup()
    {
	    if (!Yii::$app->user->isGuest) {
		    return $this->goHome();
	    }
	    $model = new SignupForm();
	    return $this->render('signup', compact('model'));
    }
	
	public function actionResponseSignup()
	{
		if(yii::$app->request->isAjax){
			Yii::$app->response->format = Response::FORMAT_JSON;
			$model = new SignupForm();
			if($model->load(yii::$app->request->post()) && $model->getLogin()){
				return ['code' => '201', 'event' => 'Success-Signup', 'message' => 'Вы успешно авторизовались!'];
			}else{
				return ['code' => '205', 'event' => 'Error-Signup', 'message' => 'Не верный логин/пароль!'];
			}
		}
		return $this->returnException();
	}
	
	public function actionProfile()
	{
		if (Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		return $this->render('profile');
	}
    
    public function actionValidate()
    {
	    $post = Yii::$app->request->post();
	    if(!is_null($post['LoginForm'])){
		    $model = new LoginForm();
	    }
	    if(!is_null($post['SignupForm'])){
		    $model = new SignupForm();
	    }
	    if(is_null($post)){
		    $model = '';
	    }
	    if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())){
		    Yii::$app->response->format = Response::FORMAT_JSON;
		    return ActiveForm::validate($model);
	    }
    }
	
	public function returnException()
	{
		$exception = Yii::$app->errorHandler->exception;
		if ($exception !== null) {
			return $this->render('error', ['exception' => $exception]);
		}
	}
}
