<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

use yii\data\Pagination;
use app\models\Questions;
use app\models\LikeAnswers;

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

        $question_id = [];
        
        $questions = [];

        $questions = Questions::find()->where(['status', [4,5,6]])->orderBy(["created_at"=>SORT_DESC]);

        $queryLike = LikeAnswers::find();
        $questions->leftJoin(['likes'=>$queryLike], 'likes.question_id = questions.id')->where(['user_id'=>$user->id])
        ->groupBy(['id']);
        $questions->orderBy(["created_at"=>SORT_DESC]);
        $result = $questions;
        
        $pages = new Pagination(['totalCount' => $questions->count(), 'pageSize' => 5, 'forcePageParam' => false, 'pageSizeParam' => false]);

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
