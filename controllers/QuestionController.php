<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\Questions;
use app\models\User;
use app\models\Answers;
use app\models\LikeAnswers;
use app\models\DislikeAnswer;
use app\models\ChangeEmail;


// AJAX
use yii\widgets\ActiveForm;


class QuestionController extends Controller
{

    public $info = [];
    public $status = [];
    public $slut = 1;
    public $user_answer = [];
    public $number = [];
    public $winner_procent = 0;
    public $win = [];

    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update','myquestions','close','voting','moderation','updatestatus','time'],
                'rules' => [

                    [ 
                        'actions' => ['index','create','update','myquestions','close','voting','moderation','updatestatus','time'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],
                    [ 
                        'actions' => ['index','close'],
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
        return $this->render(
            'index',
            [
                "questions"=>Questions::find()->where(["status"=>[4]])->orderBy(["data"=>SORT_ASC])->all(),
            ]
        );
    }

    //Внутреннея страница

    public function actionView($slug){

        $questions = Questions::find()->where(["id"=>$slug])->all();
        return $this->render(
            'view',
            [
                "questions"=>$questions,
            ]
        );
    }

    // Смена статуса по времени

    public function actionTime(){

        $questions = Questions::find()->all();
        foreach($questions as $value){
            $first_date = new \DateTime("now");
            $second_date = new \DateTime("@".$value->data);
            $interval = $second_date->diff($first_date);

            if($interval->d == 1){
                if($value->status == 4){

                    $value->status = 5;
                    $value->update(0);

                }
            }

            if($interval->d == 2){
                if($value->status == 5){

                    $value->winner_id = $this->actionWinner($value->id, $value->owner_id);
                    $value->status = 6;
                    $value->update(0);
                    
                    $users = User::find()->where(["id"=> $value->winner_id])->one();
                    $users->money = $value->coast;
                    $users->update(0);

                    $this->user_answer = [];
                    $this->win = [];

                }
            }

        }

    }

    // Выбор победителя

    public function actionWinner($id, $user){

        $answer = Answers::find()->where(['id_questions'=>$id])->all();
        echo "<pre>";

        foreach($answer as $value){

            $like = LikeAnswers::find()->where(['id_answer'=>$value->id])->one();

            $dislike = DislikeAnswer::find()->where(['id_answer'=>$value->id])->one();

            $slit_like = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM like_answer WHERE id_answer=:ID_ANSWER",["ID_ANSWER"=>$value->id])->queryOne();

            $slit_dislike = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM dislike_answer WHERE id_answer=:ID_ANSWER",["ID_ANSWER"=>$value->id])->queryOne();
            
            $this->winner_procent = $slit_like['count'];

            $this->winner_procent = $this->winner_procent - $slit_dislike['count'];

            if($this->winner_procent < 0){
                $this->winner_procent = 0;
            }

            $this->winner_procent = $this->winner_procent/100;
            
            array_push($this->user_answer, array('id_user' => $value->id_user, 'winner_procent' => $this->winner_procent));
            array_push($this->number, $this->winner_procent);
            
        }
      

        
    
        
        $winner = max($this->number);

        $i = 0;

        while($i < count($this->user_answer)){

           if($this->user_answer[$i]['winner_procent'] == $winner){
              array_push($this->win, array($this->user_answer[$i]['id_user']));
           }

            $i++;
            
        }

        $leight = count($this->win) - 1;

        if($leight < 0){
            $leight = 0;
        }

        $user_winner = rand(0, $leight);

        if (empty($this->win)) {
            $this->win = ['0'];
        }

        return $this->win[$user_winner][0];

    }
    
    // Страница моих вопросов

    public function actionMyquestions(){
        
        $user=Yii::$app->user->identity;

        $questions = Questions::find()->where(["owner_id"=>$user->id])->all();

        return $this->render(
            '_myquestion',
            [
                "questions"=>$questions,
            ]
        );
    }

    // Модерация вопросов

    public function actionModeration(){
        $user=Yii::$app->user->identity;
        if($user->moderation == 1 && $user->key == "jG23zxcmsEKs**aS431"){
            $questions = Questions::find()->where(["status"=>[1,2,3]])->all();
            return $this->render(
                '_moderation',
                [
                    "questions"=>$questions,
                ]
            );
        } else {
            header('Location: /');
            exit;
        }
    }

    public function actionUpdatestatus(){

        $user=Yii::$app->user->identity;

        if($user->moderation == 1 && $user->key == "jG23zxcmsEKs**aS431"){

            $request = Yii::$app->request;

            $this->info = [
                $request->get('question_id'),
            ];

            $this->status = [
                $request->get('status_id'),
            ];

            

            foreach($this->status as $value){
                if($value[0] == 1){
                    $this->slut = 4;
                }
                if($value[0] == 0){
                    $this->slut = 2;
                }
            }
            
            foreach($this->info as $post){
                
                $questions = Questions::find()->where(['id'=>$post])->one();

                $questions->status = $this->slut;

                return $questions->update(0);
                
            }

        } else {
            header('Location: /');
            exit;
        }
    }

    // Страница закрытых вопросов

    public function actionClose(){
        return $this->render(
            '_close',
            [
                "questions"=>Questions::find()->where(["status"=>[6]])->orderBy(["data"=>SORT_ASC])->all(),
            ]
        );
    }

    // Страница вопросов в статусе голосования

    public function actionVoting(){
        return $this->render(
            '_close',
            [
                "questions"=>Questions::find()->where(["status"=>[5]])->orderBy(["data"=>SORT_ASC])->all(),
            ]
        );
    }

    public function actionCreate()
    {
        $model = new Questions();

        if ($model->load(Yii::$app->request->post())) {
            $user = Yii::$app->user->identity;
            $model->owner_id=$user->id;
            $model->data=strtotime('now');
            $model->status=1;
            $model->grand= \Yii::t('app','Russian');
            if($model->save()){
                return $this->redirect('/questions/view/'.$model->id.'');
            }
        }

        return $this->render(
            'create',
            [
                "model"=>$model,
            ]
        );
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
        
    }
  
    
}
