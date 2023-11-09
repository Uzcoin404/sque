<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\Pagination;

use app\models\Queue;
use app\models\User;
use app\models\ChangeEmail;
use app\models\LikeAnswers;
use app\models\DislikeAnswer;
use app\models\Questions;
use app\models\ViewsAnswers;
use app\models\Answers;

// AJAX
use yii\widgets\ActiveForm;
class UserController extends Controller
{
    public $info = [];
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','get','update','download','status','userlist','infouser','tableuser'],
                'rules' => [

                    [
                        'actions' => ['index','get','update','download','status','userlist','infouser','tableuser'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [ 
                        'actions' => ['infouser'],
                        'allow' => true,
                        'roles' => ['?'], 
                    ],
                ],
            ],
            
        ];
    }

   
    //Главный экран
    public function actionIndex()
    {
        
        //$this->layout="/none";
        $model= Yii::$app->user->identity;
        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if($model->imageFile){
                $model->image=$model->upload();
                $model->imageFile="";
            }
            if($model->save()){
                $this->redirect("/main");
            }
            
        }

        return $this->render(
            'index',
            [
                'model'=>$model,
            ]
        );
    }

    //Страница всех пользователей для админа
    public function actionUserlist(){
        $user= Yii::$app->user->identity;
        if($user->moderation == 1){
            
            $users = User::find();

            $pages = new Pagination(['totalCount' => $users->count(), 'pageSize' => 5, 'forcePageParam' => false, 'pageSizeParam' => false]);
    
            $users = $users->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

            return $this->render(
                'user_list',
                [
                    'model'=>$users,
                    "pages"=>$pages,
                ]
                );
        }else{
            $this->redirect("/");
        }
    }
    
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdate()
    {
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $user=Yii::$app->user->identity;
        $model=$this->findModel($user->id);
        
            if ($request->isPost && $model->load($request->post())) {
                
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if(MD5($model->email)!=MD5($user->email)){
                    $ChangeEmail=new ChangeEmail();
                    $ChangeEmail->email=$model->email;
                    $ChangeEmail->user_id=$user->id;
                    $ChangeEmail->status=1;
                    $ChangeEmail->date=strtotime(date('Y-m-d 00:00:00'));
                    $ChangeEmail->hash=MD5($ChangeEmail->date."user".$user->id."".date("Y-m-d H:i:s"));
                    if($ChangeEmail->save()){
                        return ['success' =>$this->sendEmail($ChangeEmail->email,"Смена рабочей почты",$ChangeEmail->getEmailText())];
                    }else{
                        return ['success' =>$ChangeEmail->getErrors()]; 
                    }
                    $model->email=$user->email;
                }
                if(isset($model->imageFile)){
                    $model->image=$model->upload();
                    $model->imageFile="";
                }
              
                if($model->save()){
                    $this->redirect('/');
                }
            }
        
        
        return $this->redirect('/');
    
    }

    public function actionRead(){
        return $this->render(
            'read',
        );
    }

    public function actionStatus(){

        $user = Yii::$app->user->identity;

        $request = Yii::$app->request;

        $this->info = [
            $request->get('status'),
        ];

        $user->read = $this->info[0];

        return $user->update(0);
        
    }

    public function actionInfouser(){

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->request;

        $this->info = [
            $request->get('id_user'),
        ];

        $user = User::find()->where(['id'=>$this->info[0]])->one();

        $like = LikeAnswers::find()->where(['id_user'=>$this->info[0]])->all();
        $dislike = DislikeAnswer::find()->where(['id_user'=>$this->info[0]])->all();
        $answers = Answers::find()->where(['id_user'=>$this->info[0]])->all();
        $questions = Questions::find()->where(['owner_id'=>$this->info[0]])->all();

        $like_count = count($like);
        $dislike_count = count($dislike);
        $answers_count = count($answers);
        $questions_count = count($questions);
        $date = date('d.m.Y', $user->create_at);
        $date_online = date('d.m.Y', $user->date_online);

        \Yii::$app->response->format = 'json';

        return(
            [
            'date'=>$date,
            'questions_count'=>$questions_count,
            'answers_count'=>$answers_count,
            'like_count'=>$like_count,
            'dislike_count'=>$dislike_count,
            'date_online'=>$date_online,
            ]
        );

    }
  
    public function actionGet(){
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isPost) {
            $this->layout="/none";
            $model= Yii::$app->user->identity;
            
            return [
                'success' =>  $this->renderAjax('_form_update', [
                                'model' => $model,
                            ])
            ];
           
        }
        return ['success' => 0];
    }


    public function sendEmail($to,$subject,$body){
        Yii::$app->mailer->compose()
        ->setTo([$to])
        ->setFrom("noreply@my-novel.online")
        ->setSubject($subject)
        ->setHtmlBody($body)
        ->send();

        return true;
    }

    public function actionDownload(){
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
     
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $user=Yii::$app->user->identity;
            $Downloadqueue=new Queue();
            $Downloadqueue->id_model=$user->id;
            $Downloadqueue->type="USER_DOWNLOAD";
            $Downloadqueue->status=1;
            if($Downloadqueue->save()){
                return [
                    "success"=>1,
                ];
    
            }
            //Получить все активные книги
            //создать папки
            //Получить персонажей 
            //Получить предметы
            //Получить локации
            //Получить Тексты
            //Получить заметки
            //Архивация
        }
        return [
            "success"=>0,
        ];
    }

    public function actionTableuser(){

        $user_admin = Yii::$app->user->identity;

        if($user_admin && $user_admin->moderation == 1){

            $table = [];

            $users = User::find()->where(['moderation'=>0])->all();

            // echo "<pre>";
            // print_r($users);
            // echo "</pre>";

            $number = 0;
    
            foreach($users as $user){
                $like = LikeAnswers::find()->where(['id_user'=>$user->id])->all();
                $dislike = DislikeAnswer::find()->where(['id_user'=>$user->id])->all();
                $like_count = count($like); // 4 колво лайков
                $dislike_count = count($dislike); // 7 колво дизлайки    
                $ViewsAnswers_noclick = ViewsAnswers::find()->where(['id_user'=>$user->id,'button_click'=>0])->all();
                $ViewsAnswers_noclick_count = count($ViewsAnswers_noclick); // колво ответов где поставил лайк или диз но не нажал на кнопку
                $ViewsAnswers_click = ViewsAnswers::find()->where(['id_user'=>$user->id,'button_click'=>1])->all();
                $ViewsAnswers_click_count = count($ViewsAnswers_click); // колво ответов где поставил лайк диз и нажал кнопку

                // лайк и не нажал на кнопку
                $likes_noclick_count = 0;

                foreach ($ViewsAnswers_noclick as $noclick) {
                    $likes_noclick = LikeAnswers::find()->where(['id_user'=>$user->id, 'id_answer'=>$noclick])->all();
                    $likes_noclick ? $likes_noclick_count++ : 0;
                }

                // дизлайк и не нажал на кнопку
                $dislike_noclick_count = 0;

                foreach ($ViewsAnswers_noclick as $noclick) {
                    $dislikes_noclick = DislikeAnswer::find()->where(['id_user'=>$user->id, 'id_answer'=>$noclick])->all();
                    $dislikes_noclick ? $dislike_noclick_count++ : 0;
                }

                // лайк и нажал кнопку
                $likes_click_count = 0;

                foreach ($ViewsAnswers_click as $click) {
                    $likes_click = LikeAnswers::find()->where(['id_user'=>$user->id, 'id_answer'=>$click])->all();
                    $likes_click ? $likes_click_count++ : 0;
                }

                // дизлайк и нажал кнопку
                $dislike_click_count = 0;

                foreach ($ViewsAnswers_click as $click) {
                    $dislike_click = DislikeAnswer::find()->where(['id_user'=>$user->id, 'id_answer'=>$click])->all();
                    $dislike_click ? $dislike_click_count++ : 0;
                }
                

                // if ($user->username == 'logggin') {
                //     echo "<pre>";
                //     print_r("лайки c кнопкa - " . $likes_click_count . " дизлайки c кнопкa - " . $dislike_click_count);
                //     echo "</pre>";
                // }

                if($like_count|| $dislike_count && $ViewsAnswers_noclick_count){
                    if($dislike_count> 0 && $like_count > 0){
                        $number = $like_count + $dislike_count;
                    } else {
                        if($dislike_count > 0){
                            $number = $dislike_count;
                        } else {
                            $number = $like_count;
                        }
                    }
                                            
                    $procent_like =  $number/100;
                                            
                    $procent_noclick = $ViewsAnswers_noclick_count/$procent_like;

                    $procent = round($procent_noclick,2);

                } else {
                    $procent = 0;
                }

                if($likes_noclick_count > 0 || $dislike_click_count > 0) {
                    array_push($table, array(
                        'user' => $user->username, // имя
                        'sum' => $likes_noclick_count + $dislike_noclick_count, // Сумма лайков и дизов где не нажата кнопка
                        'like_count' => $like_count, // Сумма лайков
                        'likes_click_count' => $likes_click_count, // Лайки и нажал на кнопку
                        'likes_noclick_count' => $likes_noclick_count, // Лайки и не нажал на кнопку
                        'dislike_click_count' => $dislike_click_count, // Дизлайки и нажал на кнопку
                        'dislike_noclick_count' => $dislike_noclick_count, // Дизлайки и не нажал на кнопку
                        'dislike_count' => $dislike_count, // Сумма дизлайков
                    ));
                }
            }
            usort($table, function($a, $b){
                return ($b['sum'] - $a['sum']);
            });
            return $this->render(
                'table',
                [
                    "table"=>$table,
                ]
            );

        } else {
            return $this->redirect('/');
        }
    }
}
