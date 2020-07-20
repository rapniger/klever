<?php
namespace api\controllers;

use admin\models\PageModel;
use common\models\Author;
use Yii;
use yii\helpers\ArrayHelper;
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
class DocController extends Controller
{
	/**
	 * @return string|Response
	 */
	public function actionIndex()
    {
    	$action = 'findBook';
    	$model = 'admin\models\BookModel';
    	//$findModel = '';
    	//$findModel = new $model();
    	var_dump(class_exists($model));
    	//$findModel = (new $models());
	    //$asd = yii::$app->aliases();
	    //var_dump($asd); die;
    	//$asd = new ();
    	//var_dump($asd);
    	/*$model = 'asd';
    	$data = [
    		'model' => [
    		    'name' => 'asasd',
			    'subname' => 'asd',
		    ],
	    ];
    	//$d = ArrayHelper::map($data, 'model', 'model');
    	var_dump($d);*/
        return $this->render('index');
    }
    
    public function actionError()
    {
	    $exception = [
		    'status' => Yii::$app->errorHandler->exception->statusCode,
		    'message' => Yii::$app->errorHandler->exception->getMessage(),
	    ];
	    return $this->render('error', compact('exception'));
    }
}
