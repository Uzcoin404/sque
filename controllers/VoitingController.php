<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\Pagination;
use yii\data\ArrayDataProvider;

use app\models\Views;
use app\models\Questions;
use app\models\User;
use app\models\LikeAnswers;
use app\models\DislikeAnswer;

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
        
        $answer_like = LikeAnswers::find()->andWhere(['user_id'=>$user->id])->all();

        $answer_dislike = DislikeAnswer::find()->andWhere(['user_id'=>$user->id])->all();

        $question_id = [];
        
        $questions = [];

        if($answer_like){
            
            foreach($answer_like as $value){
               array_push($question_id, $value->question_id);
            }

        }
        if($answer_dislike){
            foreach($answer_dislike as $value){
                array_push($question_id, $value->question_id);
            }
        }
        
        $question_id = array_unique($question_id, SORT_REGULAR);
        
        foreach($question_id as $value){

            array_push($questions, $value);
            
        }
        $question = Questions::find()->where(["status"=>[5,6],"id"=>$value])->andWhere(['<=', 'created_at', time() - 24 * 3600])->orderBy(["updated_at"=>SORT_DESC])->one();

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
        if(!isset($questions->id)) return $this->redirect("/");
        $this->ViewCreate($slug);
        if($questions->status == 5){
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

    public function actionVoting(){
        // $questions = Questions::find()->where(["status"=>[5]])->orderBy(["cost"=>SORT_DESC]);

        // $pages = new Pagination(['totalCount' => $questions->count(), 'pageSize' => 5, 'forcePageParam' => false, 'pageSizeParam' => false]);

        // $questions = $questions->offset($pages->offset)
        // ->limit($pages->limit)
        // ->all();

        // return $this->render(
        //     'voting',
        //     [
        //         "questions"=>$questions,
        //         "pages"=>$pages,
        //     ]
        // );

        $questions = Questions::find()
        ->where(["status"=>[5]])
        ->orderBy(["cost"=>SORT_DESC]);

        $pages = new Pagination(['totalCount' => $questions->count(), 'pageSize' => 10, 'forcePageParam' => false, 'pageSizeParam' => false]);

        $questions = $questions
        ->offset($pages->offset)
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
            $users = Yii::$app->user->identity;
            
            if($users){
                $model = User::find()->where(['id'=>$users->id])->one();

                $model->date_online = time();
        
                $model->update();
            }

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

        $user_id = '';
        $type = '';
        $moderation = '';

        if($users){
            $user_id = $users->id;
            $type = 1;
            $moderation = $users->moderation;
        } else {
            $user_id = 1;
            $type = 0;
        }
        if($users){
            if(!$users->moderation){

                $view = Views::find()->where(['question_id'=>$slug,'user_id'=>$user_id])->one();
    
                $questions = Questions::find()->where(['id'=>$slug])->one();
    
                if($questions->status < 6){
                    if(!$view){
                        $views = new Views();
                        $views->question_id = $slug;
                        $views->created_at = time();
                        $views->user_id = $user_id;
                        $views->user_type = $type;
                
                        $views->save();
                    }
                }
            }
        }

    }

    
    
}
