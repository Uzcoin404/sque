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


class OpenController extends Controller
{

    public $info = [];
    public $status = [];
    public $slut = 1;
    public $user_answer = [];
    public $number = [];
    public $winner_procent = 0.0;

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
                        'actions' => ['index','create','close','voting','filter','closeview','votingview','myquestionview','search', 'time'],
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
        $questions = Questions::find()->where(["status"=>[4]])->orderBy(["data_status"=>SORT_DESC]);

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

        $users = Yii::$app->user->identity;

        if($users){
            $model = User::find()->where(['id'=>$users->id])->one();

            $model->date_online = strtotime("now");
    
            $model->update();
        }

        $questions = Questions::find()->where(["id"=>$slug])->all();
        if($questions[0]->status == 4 || $questions[0]->status == 2 || $questions[0]->status == 1){
            return $this->render(
                'view',
                [
                    "questions"=>$questions,
                ]
            );
        } else {
            $this->redirect("/");
        }
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
        if(!$moderation){

            $view = Views::find()->where(['id_questions'=>$slug,'id_user'=>$id_user])->one();

            $questions = Questions::find()->where(['id'=>$slug])->one();
            if($users){
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

    // Поиск

    public function actionSearch(){

        $text = $_GET['text'];

        $id_question = [];

        $search = 1;

        $questions = [];

        $questions = Questions::find()->where(["status"=>[4,5,6]])->andWhere(
            [
                'or',
                ['like','text',$text],
                ['like','title',$text]
            ]
        )->orderBy(["coast"=>SORT_DESC])->all();
  
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
                $model->date_changes = 1;

                if($model->status == 4){
                    $model->data_open = $model->data;
                } elseif ($model->status == 5){
                    $model->data_voiting = $model->data;
                }

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

    public function actionSetStatusActive(){

        $questions = Questions::find()->where(['status' => 4])->andWhere(["<=","data",strtotime("-1 day")])->all();

        foreach($questions as $value){
            if($value->status == 4){
                        
                $value->status = 5;
                if(!$value->date_changes){
                    $value->data_open = strtotime("now");
                }
                $value->data_status = strtotime("now");
                $value->data = strtotime("now");
                $value->update(0);
            }
        }
    }

    public function array_swap(array &$array, $key, $key2)
    {
        if (isset($array[$key]) && isset($array[$key2])) {
            list($array[$key], $array[$key2]) = array($array[$key2], $array[$key]);
            return true;
        }

        return false;
    }

    // Смена статуса по времени

    public function actionTime(){

        $questions = Questions::find()->where(['status' => 5])->andWhere(["<=","data",strtotime("-1 day")])->all(); 
        // если надо сменить статус, то раскомментируйте эту строку, она не работает, так что перенос будет работать независимо от времени. 
        // $questions = Questions::find()->where(['status' => 5])->andWhere(["<=","data",strtotime("-1")])->all();
         echo '<pre>';
  
        foreach($questions as $value) {
              
            $i = 0;
           
            $this->user_answer = [];
            
            $winner_id = $this->actionWinner($value->id, $value->owner_id);

            $winners_number = 0;

            foreach($winner_id as $id) {
                if($id['number'] == 1){
                    $winners_number++;
                }
            }

          /*  foreach($winner_id as $key => $item) {
       
                $dislikeItem = DislikeAnswer::find()->where(['id_user' => $item['id_user'], 'id_questions' => $value['id']])->count();
                $winner_id[$key]['dislike'] = $dislikeItem;
            }
            print_r($winner_id); exit;

            for ($i = 0; $i < count($winner_id); $i++) { 
                for ($j = 1; $j < count($winner_id); $j++) {

                    if ($winner_id[$i]['number'] == $winner_id[$j]['number']) {

                        echo '|';
                        print_r($winner_id[$i]['dislike']);
                        echo '<>';
                        print_r($winner_id[$j]['dislike']);
                        echo '|';

                        if ($winner_id[$i]['dislike'] > $winner_id[$j]['dislike']) {
                            print_r('ok');
                            $old = $winner_id[$i];
                            $winner_id[$i] = $winner_id[$j];
                            $winner_id[$j] = $old;
                        }
                    }
                }
            }*/
            
            if($value->winner_id){
                foreach($value->winner_id as $id){

                    $users = User::find()->where(["id"=> $id['id_user']])->one();

                    if($users){
                        if(!$users->money){
                            $users->money = $value->coast/$winners_number + 0;
                        } else {
                            $users->money = $value->coast/$winners_number + $users->money;
                        }
                        $users->update(0);
                    } 

                }
                if(!$value->date_changes){
                    $value->data_voiting = strtotime("now");
                }
                $value->data = strtotime("now");
                $value->status = 6;
                $value->update(0);

                $i++;
            } else {
                $value->data = strtotime("now");
                $value->status = 6;
                $value->update(0);
            }

        }
        
        // echo 'ok';
        // exit;
        $this->actionSetStatusActive();
    }


    // Выбор победителя

    public function actionWinner($id, $user){
        $win=[];
        $answers_number_win = [];
        $answers=[];
        $answer = Answers::find()->where(['id_questions'=>$id])->orderBy(['data'=>SORT_DESC])->all();
      
        foreach($answer as $value){

            $this->winner_procent= LikeAnswers::find()->where(['id_answer'=>$value->id])->count();
            $this->winner_procent = round(100/(DislikeAnswer::find()->where(['id_answer'=>$value->id])->count()+$this->winner_procent), 2);

            if($value->id_user){
                $answers[$value->id_user]=$value->id;
                $win[$this->winner_procent][]=$value->id_user;
            }
           
            
            
        }  
  
      //  $dislikeItem = DislikeAnswer::find()->where(['id_user' => $item['id_user'], 'id_questions' => $value['id']])->count();
      //  $winner_id[$key]['dislike'] = $dislikeItem;
    
 
        krsort($win);
        $win = array_reverse($win);
   
        $winner=[];
        $number=0;

        foreach($win as $k=>$values){
            
            foreach($values as $value){
                
                array_push($winner,array('id_user' => $value, 'number'=> count($win) - $number));
                $answer=Answers::find()->where(['id'=>$answers[$value]])->one();
                $answer->number= count($win) - $number;//$winner[$number]['number'];
                $answer->update(0);
            }
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
