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
        
        $answer_like = LikeAnswers::find()->where(['id_user'=>$user->id])->all();

        $answer_dislike = DislikeAnswer::find()->where(['id_user'=>$user->id])->all();

        $id_questions = [];
        
        $questions = [];

        if($answer_like){
            
            foreach($answer_like as $value){
               array_push($id_questions, $value->id_questions);
            }

        }
        if($answer_dislike){
            foreach($answer_dislike as $value){
                array_push($id_questions, $value->id_questions);
            }
        }
        
        $id_question = array_unique($id_questions, SORT_REGULAR);
        
        foreach($id_question as $value){

            $question = Questions::find()->where(["status"=>[5,6],"id"=>$value])->orderBy(["coast"=>SORT_DESC])->one();
            array_push($questions, $question);
            
        }

        $count = count($questions);

        $provider = new ArrayDataProvider([
            'allModels' => $questions,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

     

        $files = $provider->getModels();    

        return $this->render(
            'index',
            [
                "questions"=>$files,
                "provider"=>$provider,
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
