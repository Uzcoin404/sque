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
use app\models\CloseAnswer;
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


class CloseController extends Controller
{
    public $info = [];
    public $id_question = [];
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
        $questions = Questions::find()->where(['in', 'status', [6,7]])->orderBy(["date_close"=>SORT_DESC])->all();

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

            $model->date_online = strtotime("now");
    
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

        $this->id_question = [
            $request->get('id_question'),
        ];

        foreach($this->info as $post){
      
            if(!$moderation){

                $questions = Questions::find()->where(['id'=>$this->id_question[0][0]])->one();
                $Views=CloseAnswer::find()->where(["id_answer"=>$post,"id_user"=>$user->id])->one();
            
                                
                if(!isset($Views->id)){
                            
                        $Views = new CloseAnswer();
                        $Views->id_user=$user->id;
                        $Views->id_answer=$post;
                        $Views->id_question=$this->id_question[0][0];
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
            $questions = Questions::find()->where(['in', 'status', [6,7]]);
                $exception = Yii::$app->errorHandler->exception;
                if (empty($_GET)) {
                    return $this->redirect(['/questions/close']);
                }
                $sort= $_GET['sorts'];
                if($sort=="coast-ASC"){
                    echo 1;
                    $questions->orderBy(['coast'=>SORT_DESC]);
                }
                else if ($sort=="coast-DESC"){
                    $questions->orderBy(['coast'=>SORT_ASC]);
                }
                else if($sort=="view-ASC"){
                    $questions->orderBy('views.viewcount ASC');
                }
                else if($sort=="view-DESC"){
                    $questions->orderBy('views.viewcount DESC');
                }
                else if($sort=="answers-ASC"){
                    $questions->orderBy('answers.answerscount ASC');
                }
                else if($sort=="answers-DESC"){
                    $questions->orderBy('answers.answerscount DESC');
                }
                else if($sort=="likes_answer-ASC"){
                    $questions->orderBy('like_answer.likecount ASC');
                }
                else if($sort=="likes_answer-DESC"){
                    $questions->orderBy('like_answer.likecount DESC');
                }

            // $queryLike = LikeAnswers::find()
            // ->select('id_questions,count(id_user) as likecount')
            // ->groupBy('id_questions')
            // ->groupBy('id_user');
            // $questions->leftJoin(['like_answer'=>$queryLike], 'like_answer.id_questions = questions.id');  
            
            $queryLike = LikeAnswers::find()
            ->select('id_questions,count(DISTINCT(id_user)) as likecount')
            ->groupBy('id_questions');
            $questions->leftJoin(['like_answer'=>$queryLike], 'like_answer.id_questions = questions.id');

            $querydisLike = Dislike::find()
            ->select('id_questions,count(id_user) as dislikecount')
            ->groupBy('id_questions');
            $questions->leftJoin(['dislikepost'=>$querydisLike], 'dislikepost.id_questions = questions.id');

            $queryViews = Views::find()
            ->select('id_questions,count(id_user) as viewcount')
            ->groupBy('id_questions');
            $questions->leftJoin(['views'=>$queryViews], 'views.id_questions = questions.id');

            $queryAnswers= Answers::find()
            ->select('id_questions,count(id_user) as answerscount')
            ->groupBy('id_questions');
            $questions->leftJoin(['answers'=>$queryAnswers], 'answers.id_questions = questions.id');

        return $this->render(
            'index',
            [
            "questions"=>$questions->all(),
            ]
        );
    

    }

   
}
