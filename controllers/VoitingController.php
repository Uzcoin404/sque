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


class VoitingController extends Controller
{

    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','filter','voting'],
                'rules' => [

                    [ 
                        'actions' => ['index','view','filter','voting'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],
                    [ 
                        'actions' => ['index','view','filter','voting'],
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

        $this->ViewCreate($slug);

        $questions = Questions::find()->where(["id"=>$slug])->one();
        return $this->render(
            'view',
            [
                "question"=>$questions,
            ]
        );
    }

    public function actionVoting(){
        $questions = Questions::find()->where(["status"=>[5]])->orderBy(["coast"=>SORT_DESC]);

        $pages = new Pagination(['totalCount' => $questions->count(), 'pageSize' => 5, 'forcePageParam' => false, 'pageSizeParam' => false]);

        $questions = $questions->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

        return $this->render(
            'voting',
            [
                "questions"=>$questions,
                "pages"=>$pages,
            ]
        );
    }

      // Страница вопросов в статусе голосования
    
      public function actionVotingview($slug)
      {
          $this->ViewCreate($slug);
  
          $questions = Questions::find()->where(["id"=>$slug])->one();
          return $this->render(
              '_viewVoiting',
              [
                  "question"=>$questions,
              ]
          );
      }

      public function ViewCreate($slug){
        $users = Yii::$app->user->identity;

        $id_user = '';
        $type = '';
        $moderation = '';

        if($users){
            $id_user = $users->id;
            $type = 1;
            $moderation = $users->moderation;
        } else {
            $id_user = 1;
            $type = 0;
        }
        if(!$users->moderation){

            $view = Views::find()->where(['id_questions'=>$slug,'id_user'=>$id_user])->one();

            $questions = Questions::find()->where(['id'=>$slug])->one();

            if($questions->status < 6){
                if(!$view){
                    $views = new Views();
                    $views->id_questions = $slug;
                    $views->data = strtotime("now");
                    $views->id_user = $id_user;
                    $views->type_user = $type;
            
                    $views->save();
                }
            }
        }
    }

    
    
}
