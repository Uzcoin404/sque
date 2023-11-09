<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\User;
use app\models\Like;
use app\models\ViewsAnswers;
use app\models\Answers;
use app\models\LikeAnswers;
use app\models\DislikeAnswer;
use app\models\ChangeEmail;
use app\models\Questions;


// AJAX
use yii\widgets\ActiveForm;


class LikeController extends Controller
{
    public $user_id = [];
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','user'],
                'rules' => [

                    [ 
                        'actions' => ['index','block','filterlike'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],

                    [ 
                        'actions' => ['block','filterlike'],
                        'allow' => true,
                        'roles' => ['?'], 
                    ],

                ],
            ],
            
        ];
    }
    
    public $info = [];
    public $user_info = [];
    public $image = [];

    public function actionIndex()
    {
        $like = new Like();
        $request = Yii::$app->request;

        $user=Yii::$app->user->identity;

        $like->id_questions = 12;
        $like->id_user = $user->id;
        $like->data = strtotime('now');
    
        $this->LikeAnswers();

        $like->save();

        
    }

    public function LikeAnswers(){

        $views = "";

        $like_answer = new LikeAnswers();

        $request = Yii::$app->request;

        $user=Yii::$app->user->identity;

        $this->info = [
            $request->get('id_answer_like'),
        ];

        foreach($this->info as $post){
          
            foreach($post as $like){
                $id_answer=$like['answer'];
                $answer_views = ViewsAnswers::find()->where(["id_answer"=>$id_answer,"id_user"=>$user->id])->one();
                $answer=LikeAnswers::find()->where(["id_answer"=>$id_answer,"id_user"=>$user->id])->one();
                $answer_dis=DislikeAnswer::find()->where(["id_answer"=>$id_answer,"id_user"=>$user->id])->one();
                if($answer || $answer_dis){
                    if($like['status'] == 1){
                        $answer->delete();
                        if (!$answer_views->button_click) {
                            $answer_views->delete();
                        }
                        // $answer_views->delete();
                    }
                    
                    return 0;
                } else {
                    $answer=Answers::find()->where(["id"=>$id_answer])->one();
                    $question = Questions::find()->where(['id'=>$like['question'][0]])->one();
                    if($question->status == 5){
                        if(isset($answer->id_user)){
                            if($user){
                                if($answer->id_user!=$user->id && $user->moderation == 0){
                                    $like_answer = new LikeAnswers();                    
                                    $like_answer->id_answer = $id_answer;
                                    $like_answer->id_questions = $like['question'][0];
                                    $like_answer->id_user = $user->id;
                                    $like_answer->data = strtotime('now');
                                    $like_answer->save(0);
                                    if(!$answer_views){
                                        $views = new ViewsAnswers();
                                        $views->id_answer=$id_answer;
                                        $views->id_user=$user->id;
                                        $views->type_user=1;
                                        $views->data=strtotime("now");
                                        $views->save(0);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

    }

    public function actionBlock(){
       
        $request = Yii::$app->request;

        $this->info = [
            $request->get('id_block'),
        ];

        $answer = LikeAnswers::find()->where(['id_answer'=>$this->info[0]])->all();

        foreach($answer as $value){
            array_push($this->user_id,$value->id_user);
        }

        foreach($this->user_id as $user){
            $user_info  = User::find()->where(['id'=>$user])->one();
            array_push($this->user_info,array("user"=>$user_info->username, "img"=>$user_info->image));
           
        }

        \Yii::$app->response->format = 'json';

        return $this->user_info;
       
    }
    
    public function actionFilterlike(){
        // ->where(['id_questions'=>$_GET['id_question']])
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $status=0;
        $result="";        
        $data = Yii::$app->request->post();
        $sort = $data['sorts'];
        $id = $data['id'];   
        $answer = Answers::find()->where(['in', 'id_questions', $id]);
        $answerLike = LikeAnswers::find()
        ->select('id_answer,count(id_questions) as like_answercount')
        ->groupBy('id_answer');
        if($sort == "DESC"){
            $answer->orderBy('like_answer.like_answercount DESC');
        }
        if($sort == "ASC"){
            $answer->orderBy('like_answer.like_answercount ASC');
        }
        if($sort == "ALL"){
            $answer->orderBy('number ASC');
        }
        $answer->leftJoin(['like_answer'=>$answerLike], 'like_answer.id_answer = answers.id');

        foreach($answer->all() as $question){
            $status=1;
            $result.=$this->renderAjax("@app/widgets/views/answers/_view",["answer"=>$question,"id_questions"=>$id, "orderWinner"=>$question->number]);
        }
        return \yii\helpers\Json::encode(
            [
            'status'=>$status,
            'result'=>$result,
            'sort'=>$sort,
            ]
        );
    }
  
}
