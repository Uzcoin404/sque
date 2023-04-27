<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\Views;
use app\models\Dislike;
use app\models\Like;
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

    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update','myquestions','close','voting','moderation','updatestatus','time','change','filter','closeview','votingview','myquestionview'],
                'rules' => [

                    [ 
                        'actions' => ['index','create','update','myquestions','close','voting','moderation','updatestatus','time','text','change','filter','closeview','votingview','myquestionview'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],
                    [ 
                        'actions' => ['index','close','voting','filter','closeview','votingview','myquestionview'],
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
                "questions"=>Questions::find()->where(["status"=>[4]])->orderBy(["coast"=>SORT_DESC])->all(),
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

            if($interval->d >= 1){
                if($value->status == 4){
                    
                    $value->status = 5;
                    $value->data_open = new \DateTime("now");
                    $value->data = new \DateTime("now");
                    $value->update(0);

                }
                
                if($value->status == 5){
                   
                    $value->winner_id = $this->actionWinner($value->id, $value->owner_id);
                    $value->data_voiting = strtotime("now");
                    $value->status = 6;
                    $value->update(0);
                    
                    $users = User::find()->where(["id"=> $value->winner_id])->one();
                    $users->money = $value->coast;
                    $users->update(0);

                    $this->user_answer = [];

                }
            }

        }

    }


    // Выбор победителя

    public function actionWinner($id, $user){
        $win=[];
        $answers=[];
        $answer = Answers::find()->where(['id_questions'=>$id])->orderBy(['data'=>SORT_DESC])->all();
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
            $win[$value->id_user]=$this->winner_procent;
            $answers[$value->id_user]=$value->id;
            
        }
        asort($win);
        $winner=0;
        $number=1;
        foreach($win as $user=>$value){
            if(!$winner){
                $winner=$user;
            }
            $answer=Answers::find()->where(['id'=>$answers[$user]])->one();
            $answer->number=$number;
            $answer->update(0);
            $number++;
        }

        return $winner;

    }
    
    // Страница моих вопросов
    
    public function actionMyquestionview($slug)
    {
        $questions = Questions::find()->where(["id"=>$slug])->one();
        return $this->render(
            '_viewmyquestion',
            [
                "question"=>$questions,
            ]
        );
    }
    public function actionMyquestions(){
        
        $user=Yii::$app->user->identity;

        $questions = Questions::find()->where(["owner_id"=>$user->id])->orderBy(["coast"=>SORT_DESC])->all();

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
            $questions = Questions::find()->where(["status"=>[1,2,3]])->orderBy(["coast"=>SORT_DESC])->all();
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

    public function actionChange($slug){

        $model = Questions::find()->where(["id"=>$slug])->one();

        $questions = Questions::find()->where(["id"=>$slug])->one();

        if($questions){
            if ($model->load(Yii::$app->request->post())) {
                $user = Yii::$app->user->identity;
                $model->owner_id=$user->id;
                $model->status=1;
                if($model->save()){
                    return $this->redirect('/questions/myquestions');
                }
            }
    
            return $this->render(
                'update',
                [
                    "model"=>$model,
                    "questions"=>$questions,
                ]
            );
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

                $questions->data_status=strtotime('now');

                return $questions->update(0);
                
            }

        } else {
            header('Location: /');
            exit;
        }
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
                if($sort=="likes-ASC"){
                    $questions->orderBy(['likepost.likecount'=>SORT_ASC]);
                }else{
                    $questions->orderBy(['likepost.likecount'=>SORT_DESC]);
                }
                if($sort=="dislike-ASC"){
                    $questions->addOrderBy('dislikepost.dislikecount ASC');
                }
                if($sort=="dislike-DESC"){
                    $questions->addOrderBy('dislikepost.dislikecount DESC');
                }
                if($sort=="view-ASC"){
                    $questions->addOrderBy('views.viewcount ASC');
                }
                if($sort=="view-DESC"){
                    $questions->addOrderBy('views.viewcount DESC');
                }
                // 
            }
           // $result=$order;
            $queryLike = Like::find()
            ->select('id_questions,count(id_user) as likecount')
            ->groupBy('id_questions');
            $questions->leftJoin(['likepost'=>$queryLike], 'likepost.id_questions = questions.id');
            $querydisLike = Dislike::find()
            ->select('id_questions,count(id_user) as dislikecount')
            ->groupBy('id_questions');
            $questions->leftJoin(['dislikepost'=>$querydisLike], 'dislikepost.id_questions = questions.id');
            $queryViews = Views::find()
            ->select('id_questions,count(id_user) as viewcount')
            ->groupBy('id_questions');
            $questions->leftJoin(['views'=>$queryViews], 'views.id_questions = questions.id');
            //$result=$questions->createCommand()->getRawSql();
            foreach($questions->all() as $question){
                $status=1;
                $result.=$this->renderAjax("_viewQuestionClose",["question"=>$question]);
            }


        }
        return \yii\helpers\Json::encode(
            [
            'status'=>$status,
            'result'=>$result,
            ]
        );
    

    }
    public function actionClose(){

        $questions = Questions::find()->where(['in', 'status', [6,7]]);
        return $this->render(
            '_close',
            [
                "questions"=>$questions->all(),
            ]
        );
    }

    
    public function actionCloseview($slug){

        $questions = Questions::find()->where(["id"=>$slug])->one();
        return $this->render(
            '_viewClose',
            [
                "question"=>$questions,
            ]
        );
    }

    // Страница вопросов в статусе голосования
    
    public function actionVotingview($slug)
    {
        $questions = Questions::find()->where(["id"=>$slug])->one();
        return $this->render(
            '_viewVoiting',
            [
                "question"=>$questions,
            ]
        );
    }
    public function actionVoting(){
        return $this->render(
            '_voting',
            [
                "questions"=>Questions::find()->where(["status"=>[5]])->orderBy(["coast"=>SORT_DESC])->all(),
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
            $model->data_status=strtotime('now');
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

    public function actionText(){

        $request = Yii::$app->request;

        $this->info = [
            $request->get('id'),
            $request->get('status'),
        ];

        $answer = Answers::find()->where(['id'=>$this->info[0]])->one();

        if($this->info[1] == 1){

            return $answer->text;

        } else {

            $text = mb_strimwidth($answer->text, 0, 30, "...");
            return $text;

        }

    }
}
