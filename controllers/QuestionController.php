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
                'only' => ['index','create','update','myquestions','close','voting','moderation','updatestatus','time','change','filter','closeview','votingview','myquestionview','myvoiting','myvoitingview','search','myquestionsfilter','dateupdate','return'],
                'rules' => [

                    [ 
                        'actions' => ['index','create','update','myquestions','close','voting','moderation','updatestatus','time','text','change','filter','closeview','votingview','myquestionview','myvoiting','myvoitingview','search','myquestionsfilter','dateupdate','return'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],
                    [ 
                        'actions' => ['index','close','voting','filter','closeview','votingview','myquestionview','search'],
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
        $questions = Questions::find()->where(["status"=>[4]])->orderBy(["coast"=>SORT_DESC]);

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

    //Внутреннея страница
    
    public function actionView($slug){

        $this->ViewCreate($slug);

        $questions = Questions::find()->where(["id"=>$slug])->all();
        return $this->render(
            'view',
            [
                "questions"=>$questions,
            ]
        );
    }

    // Добавление просмотров

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

    // Поиск

    public function actionSearch(){

        $text = $_GET['text'];

        $id_question = [];

        $questions = [];

        $questions = Questions::find()->where(["status"=>[4,5,6]])->andWhere(
            [
                'or',
                ['like','text',$text],
                ['like','title',$text]
            ]
        )->all();
  
        return $this->render(
            '_search',
            [
                "questions"=>$questions,
            ]
        );
        
    }

    public function actionDateupdate($slug){

        $user=Yii::$app->user->identity;

        if($user->moderation == 1){
         
            $model = Questions::find()->where(['id'=>$slug])->one();

            if ($model->load(Yii::$app->request->post())) {

                $model->data = strtotime($model->data);
                $model->data_status = $model->data;

                $date = date("d.m.y", $model->data_status);
    
                if($model->update(0)){
                    return $this->redirect(
                        '/',
                    );
                }
            }
    
          
    
            return $this->render(
                '_dateupdate',
                [
                    "model"=>$model,
                ]
            );
        }
        
    }

    // Смена статуса по времени

    public function actionTime(){
        $questions = Questions::find()->all();
  
        foreach($questions as $value){
           
            $first_date = new \DateTime("now");
            $second_date = new \DateTime("@".$value->data);
            $interval = $second_date->diff($first_date);
            
            if($interval->d >= 1){
                
                if($value->status == 5){

                    $this->user_answer = [];
                    
                    $value->winner_id = $this->actionWinner($value->id, $value->owner_id);
                    $users = User::find()->where(["id"=> $value->winner_id])->one();

                    if($users){
                        if(!$users->money){
                            $users->money = $value->coast + 0;
                        } else {
                            $users->money = $value->coast + $users->money;
                        }
                        $users->update(0);
                    } 
                    $value->data_voiting = strtotime("now");
                    $value->data = strtotime("now");
                    $value->status = 6;
                    $value->update(0);

                }

                if($value->status == 4){
                    
                    $value->status = 5;
                    $value->data_open = strtotime("now");
                    $value->data_status = strtotime("now");
                    $value->data = strtotime("now");
                    $value->data_start = strtotime("now");
                    $value->update(0);

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


            if($value->id_user){
                $win[$value->id_user]=$this->winner_procent;
                $answers[$value->id_user]=$value->id;
            }
            
        }
        arsort($win);
        $winner=0;
        $number=1;
        foreach($win as $user=>$value){
            if(!$win){
                $win=$user;
            }
            if($number == 1){
                $winner = $user;
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

        $this->ViewCreate($slug);

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

        $questions = Questions::find()->where(["owner_id"=>$user->id])->orderBy(["coast"=>SORT_DESC]);

        $pages = new Pagination(['totalCount' => $questions->count(), 'pageSize' => 5, 'forcePageParam' => false, 'pageSizeParam' => false]);

        $questions = $questions->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

        return $this->render(
            '_myquestion',
            [
                "questions"=>$questions,
                "pages"=>$pages,
            ]
        );
    }

    public function actionMyquestionsfilter($slug){

        $questions = Questions::find()->where(["id"=>$slug])->orderBy(["coast"=>SORT_DESC])->all();

        return $this->render(
            '_myquestionfilter',
            [
                "questions"=>$questions,
            ]
        );
    }

    // Мои голосования

    public function actionMyvoitingview($slug)
    {
        $this->ViewCreate($slug);

        $questions = Questions::find()->where(["id"=>$slug])->one();
        return $this->render(
            '_viewmyvoiting',
            [
                "question"=>$questions,
            ]
        );
    }

    public function actionMyvoiting(){

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
            '_myvoiting',
            [
                "questions"=>$files,
                "provider"=>$provider,
            ]
        );

    }

    // Модерация вопросов

    public function actionModeration(){
        $user=Yii::$app->user->identity;
        if($user->moderation == 1 && $user->key == "jG23zxcmsEKs**aS431"){

            $questions = Questions::find()->where(["status"=>[1,2,3]])->orderBy(["coast"=>SORT_DESC]);

            $pages = new Pagination(['totalCount' => $questions->count(), 'pageSize' => 4, 'forcePageParam' => false, 'pageSizeParam' => false]);

            $questions = $questions->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

            return $this->render(
                '_moderation',
                [
                    "questions"=>$questions,
                    "pages"=>$pages,
                ]
            );
        } else {
            header('Location: /');
            exit;
        }
    }

    public function actionReturn($slug){

        $model = Questions::find()->where(["id"=>$slug])->one();
      
        $user=Yii::$app->user->identity;

        if($user->moderation == 1){
            if ($model->load(Yii::$app->request->post())) {
                $user = Yii::$app->user->identity;
                $model->text_return=$model->text_return;
                $model->status=2;
                if($model->update(0)){
                    
                    return $this->redirect('/questions/moderation');
                }
            }
    
            return $this->render(
                'return',
                [
                    "model"=>$model,
                ]
            );
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

            $this->slut = 2;

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

        $pages = new Pagination(['totalCount' => $questions->count(), 'pageSize' => 5, 'forcePageParam' => false, 'pageSizeParam' => false]);

        $questions = $questions->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

        return $this->render(
            '_close',
            [
                "questions"=>$questions,
                "pages"=>$pages,
            ]
        );
    }

    
    public function actionCloseview($slug){

        $this->ViewCreate($slug);

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
        $this->ViewCreate($slug);

        $questions = Questions::find()->where(["id"=>$slug])->one();
        return $this->render(
            '_viewVoiting',
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
            '_voting',
            [
                "questions"=>$questions,
                "pages"=>$pages,
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
            $model->data_start=strtotime('now');
            $model->status=1;
            $model->grand= \Yii::t('app','Russian');
            $model->data_status=strtotime('now');
            $model->text = strip_tags($model->text);
            $user_coast = User::find()->where(['id'=>$user->id])->one();
            if(!$user->money){
                return $this->redirect('/questions/myquestions');
            } else {
                $user_coast->money = $user->money - $model->coast;
            }
            $user_coast->update(0);

            if($model->save()){
                return $this->redirect(
                    '/questions/myquestionsfilter/'.$model->id.'',
                );
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
