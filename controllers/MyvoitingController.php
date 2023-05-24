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


class MyvoitingController extends Controller
{

    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view'],
                'rules' => [

                    [ 
                        'actions' => ['index','view'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],
                    [ 
                        'actions' => ['index','view'],
                        'allow' => true,
                        'roles' => ['?'], 
                    ],

                ],
            ],
            
        ];
    }

    
    public function actionIndex()
    {

        $user=Yii::$app->user->identity;

        $id_questions = [];
        
        $questions = [];

        $questions = Questions::find()->where(['in', 'status', [4,5,6]]);
        $queryLike = LikeAnswers::find();
        $questions->leftJoin(['like_answer'=>$queryLike], 'like_answer.id_questions = questions.id')->where(['id_user'=>$user->id])->orderBy(["coast"=>SORT_DESC]);
        $result = $questions;

        $pages = new Pagination(['totalCount' => $result->count(), 'pageSize' => 5, 'forcePageParam' => false, 'pageSizeParam' => false]);

        $result = $result->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        
        return $this->render(
            'index',
            [
                'questions'=>$result,
                "pages"=>$pages,
            ]
        );  
    }

    public function actionView($slug){

       
        $questions = Questions::find()->where(["id"=>$slug])->one();
        return $this->render(
            'view',
            [
                "question"=>$questions,
            ]
        );
       
    }

    

    
    
}
