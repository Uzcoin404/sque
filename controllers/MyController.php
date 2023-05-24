<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\Pagination;
use yii\data\ArrayDataProvider;

use app\models\Views;
use app\models\Dislike;
use app\models\Like;
use app\models\Questions;
use app\models\User;
use app\models\Answers;
use app\models\LikeAnswers;
use app\models\DislikeAnswer;
use app\models\ChangeEmail;
use app\models\ViewsAnswers;


// AJAX
use yii\widgets\ActiveForm;


class MyController extends Controller
{

    public $info = [];
    public $status = [];
    public $slut = 1;
    public $user_answer = [];
    public $number = [];
    public $winner_procent = 0;

    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','filter'],
                'rules' => [

                    [ 
                        'actions' => ['index','view','filter'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],
                    [ 
                        'actions' => ['index','view','filter'],
                        'allow' => true,
                        'roles' => ['?'], 
                    ],

                ],
            ],
            
        ];
    }

   
    public function actionIndex(){
        
        $user=Yii::$app->user->identity;

        $questions = Questions::find()->where(["owner_id"=>$user->id])->orderBy(["coast"=>SORT_DESC]);

        $pages = new Pagination(['totalCount' => $questions->count(), 'pageSize' => 5, 'forcePageParam' => false, 'pageSizeParam' => false]);

        $questions = $questions->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

        return $this->render(
            'index',
            [
                "questions"=>$questions,
                "pages"=>$pages,
            ]
        );
    }

	
	   // Страница моих вопросов
    
    public function actionView($slug)
    {

        $questions = Questions::find()->where(["id"=>$slug])->one();
        return $this->render(
            'view',
            [
                "question"=>$questions,
            ]
        );
    }
	
	public function actionFilter($slug){

        $questions = Questions::find()->where(["id"=>$slug])->orderBy(["coast"=>SORT_DESC])->all();

        return $this->render(
            'filter',
            [
                "questions"=>$questions,
            ]
        );

    }
}
