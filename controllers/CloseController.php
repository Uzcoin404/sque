<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

use app\models\CloseAnswer;
use app\models\Questions;
use app\models\User;


// AJAX
use yii\widgets\ActiveForm;


class CloseController extends Controller
{
    public $info = [];
    public $question_id = [];
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','filter','viewan'],
                'rules' => [

                    [ 
                        'actions' => ['index','view','filter','viewan'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],
                    [ 
                        'actions' => ['index','view','filter','viewan'],
                        'allow' => true,
                        'roles' => ['?'], 
                    ],

                ],
            ],
            
        ];
    }

    
    public function actionIndex()
    {
        $questions = Questions::find()->where(['in', 'status', [6,7]])->orderBy(["closed_at"=>SORT_DESC])->all();

        return $this->render(
            'index',
            [
                "questions"=>$questions,
            ]
        );
    }

    public function actionView($slug){
        $users = Yii::$app->user->identity;
        
        if($users){
            $model = User::find()->where(['id'=>$users->id])->one();

            $model->date_online = time();
    
            $model->update();
        }
        
        $questions = Questions::find()->where(["id"=>$slug])->one();
        if(!isset($questions->id)) return $this->redirect("/");
        
        if($questions->status == 6){
            
            return $this->render(
                'view',
                [
                    "question"=>$questions,
                ]
            );
        } else {
            $this->redirect("/");
        }
    }

    public function actionViewan(){

        $request = Yii::$app->request;

        $user=Yii::$app->user->identity;

        $moderation = 0;

        if($user){
            $moderation = $user->moderation;
        }
        
        $this->info = [
            $request->get('status_view'),
        ];

        $this->question_id = [
            $request->get('question_id'),
        ];

        foreach($this->info as $post){
      
            if(!$moderation){

                $questions = Questions::find()->where(['id'=>$this->question_id[0][0]])->one();
                $Views=CloseAnswer::find()->where(["answer_id"=>$post,"user_id"=>$user->id])->one();
            
                                
                if(!isset($Views->id)){
                            
                        $Views = new CloseAnswer();
                        $Views->user_id=$user->id;
                        $Views->answer_id=$post;
                        $Views->question_id=$this->question_id[0][0];
                        $Views->save(0);

                }
          
            }

        }
        print_r(1); exit;
    }

     // Страница закрытых вопросов
     public function actionFilter(){
        $status=0;
        $result="";

            $data = Yii::$app->request->post();
            $questions = Questions::find()->where(['in', 'questions.status', [6,7]]);
                $exception = Yii::$app->errorHandler->exception;
                if (empty($_GET)) {
                    return $this->redirect(['/questions/close']);
                }
                $sort= $_GET['sorts'];
                if($sort=="cost-ASC"){
                    $questions->orderBy(['cost'=>SORT_DESC]);
                }
                else if ($sort=="cost-DESC"){
                    $questions->orderBy(['cost'=>SORT_ASC]);
                }
                else if($sort=="view-ASC"){
                    $questions->orderBy('views.viewcount ASC');
                }
                else if($sort=="view-DESC"){
                    $questions->orderBy('views.viewcount DESC');
                }
                else if($sort=="answers-ASC"){
                    $questions->select(['questions.*', 'answers_count' => 'COUNT(answers.id)'])
                    ->leftJoin('answers', 'answers.question_id = questions.id')
                    ->groupBy('questions.id')
                    ->orderBy('answers_count ASC');
                }
                else if($sort=="answers-DESC"){
                    $questions->select(['questions.*', 'answers_count' => 'COUNT(answers.id)'])
                    ->leftJoin('answers', 'answers.question_id = questions.id')
                    ->groupBy('questions.id')
                    ->orderBy('answers_count DESC');
                }
                else if($sort=="likes_answer-ASC"){
                    $questions->select(['questions.*', 'likes_count' => 'COUNT(likes.id)'])
                    ->leftJoin('likes', 'likes.question_id = questions.id')
                    ->groupBy('questions.id')
                    ->orderBy('likes_count ASC');
                }
                else if($sort=="likes_answer-DESC"){
                    $questions->select(['questions.*', 'likes_count' => 'COUNT(likes.id)'])
                    ->leftJoin('likes', 'likes.question_id = questions.id')
                    ->groupBy('questions.id')
                    ->orderBy('likes_count DESC');
                }

            // $queryLike = LikeAnswers::find()
            // ->select('question_id,count(user_id) as likecount')
            // ->groupBy('question_id')
            // ->groupBy('user_id');
            // $questions->leftJoin(['likes'=>$queryLike], 'likes.question_id = questions.id');  
            
            // $queryLike = LikeAnswers::find()
            // ->select('question_id,count(DISTINCT(user_id)) as likecount')
            // ->groupBy('question_id');
            // $questions->leftJoin(['likes'=>$queryLike], 'likes.question_id = questions.id');

            // $querydisLike = Dislike::find()
            // ->select('question_id,count(user_id) as dislikecount')
            // ->groupBy('question_id');
            // $questions->leftJoin(['dislikepost'=>$querydisLike], 'dislikepost.question_id = questions.id');

            // $queryViews = Views::find()
            // ->select('question_id,count(user_id) as viewcount')
            // ->groupBy('question_id');
            // $questions->leftJoin(['views'=>$queryViews], 'views.question_id = questions.id');

            // $queryAnswers= Answers::find()
            // ->select('question_id,count(user_id) as answerscount')
            // ->groupBy('question_id');
            // $questions->leftJoin(['answers'=>$queryAnswers], 'answers.question_id = questions.id');

        return $this->render(
            'index',
            [
            "questions"=>$questions->all(),
            ]
        );
    

    }

   
}
