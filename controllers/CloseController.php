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


class CloseController extends Controller
{

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

    
    public function actionIndex()
    {
        $questions = Questions::find()->where(['in', 'status', [6,7]]);

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

     // Страница закрытых вопросов
     public function actionFilter(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $status=0;
        $result="";

        if (Yii::$app->request->isAjax) { 
            $data = Yii::$app->request->post();
            $questions = Questions::find()->where(['in', 'status', [6,7]]);
            foreach($data['sorts'] as $sort){
                if($sort=="date-ASC"){
                    $questions->orderBy(['data_status'=>SORT_DESC]);
                }else{
                    $questions->orderBy(['data_status'=>SORT_ASC]);
                }
                if($sort=="view-ASC"){
                    $questions->orderBy('views.viewcount ASC');
                }
                if($sort=="view-DESC"){
                    $questions->orderBy('views.viewcount DESC');
                }
                if($sort=="answers-ASC"){
                    $questions->orderBy('answers.answerscount ASC');
                }
                if($sort=="answers-DESC"){
                    $questions->orderBy('answers.answerscount DESC');
                }
               
                // 
            }
           // $result=$order;
            $queryLike = Like::find()
            ->select('id_questions,count(id_user) as likecount')
            ->groupBy('id_questions');
            $questions->leftJoin(['likepost'=>$queryLike], 'likepost.id_questions = questions.id');
            $queryLike = LikeAnswers::find()
            ->select('id_questions,count(id_user) as likecount')
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
            //$result=$questions->createCommand()->getRawSql();
            foreach($questions->all() as $question){
                $status=1;
                $result.=$this->renderAjax("_view",["question"=>$question]);
            }


        }
        return \yii\helpers\Json::encode(
            [
            'status'=>$status,
            'result'=>$result,
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
