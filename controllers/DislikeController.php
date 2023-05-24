<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\User;
use app\models\Dislike;
use app\models\DislikeAnswer;
use app\models\LikeAnswers;
use app\models\ChangeEmail;
use app\models\Answers;
use app\models\Questions;


// AJAX
use yii\widgets\ActiveForm;


class DislikeController extends Controller
{
    public $info = [];
    public $user_id = [];
    public $user_info = [];
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [

                    [ 
                        'actions' => ['index','block','filterdislike'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],

                    [ 
                        'actions' => ['block','filterdislike'],
                        'allow' => true,
                        'roles' => ['?'], 
                    ],

                ],
            ],
            
        ];
    }

    public function actionIndex()
    {
        $dislike = new Dislike();

        $request = Yii::$app->request;

        $user=Yii::$app->user->identity;

        $dislike->id_questions = 12;
        $dislike->id_user = $user->id;
        $dislike->data = strtotime('now');

        $this->DislikeAnswers();

        $dislike->save();
        

    }

    public function actionFilterdislike(){
        // ->where(['id_questions'=>$_GET['id_question']])
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $status=0;
        $result="";
        $data = Yii::$app->request->post();
        $sort = $data['sorts'];
        $id = $data['id'];
      
        $answer = Answers::find()->where(['in', 'id_questions', $id]);
        if($sort == "DESC"){
            $answer->orderBy('dislike_answer.dislike_answercount DESC');
        }
        if($sort == "ASC"){
            $answer->orderBy('dislike_answer.dislike_answercount ASC');
        }
        if($sort == "ALL"){
            $answer->orderBy('number ASC');
        }
        $answerLike = DislikeAnswer::find()
        ->select('id_answer,count(id_questions) as dislike_answercount')
        ->groupBy('id_answer');
        $answer->leftJoin(['dislike_answer'=>$answerLike], 'dislike_answer.id_answer = answers.id');
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

    public function DislikeAnswers(){
        
        $request = Yii::$app->request;

        $user=Yii::$app->user->identity;

        $this->info = [
            $request->get('id_answer_dislike'),
        ];
        foreach($this->info as $post){

            foreach($post as $id_answers){
                $id_an=$id_answers['answer'];
                $dislike_answer=DislikeAnswer::find()->where(["id_answer"=>$id_an,"id_user"=>$user->id])->one();
                $like_answer=LikeAnswers::find()->where(["id_answer"=>$id_an,"id_user"=>$user->id])->one();
                if($dislike_answer || $like_answer){
                    if($id_answers['status'] == 1){
                        $dislike_answer->delete();
                    } 
                } else {
                    $answer=Answers::find()->where(["id"=>$id_an])->one();
                    $question = Questions::find()->where(["id"=>$id_answers['question'][0]])->one();
                    if($question->status == 5){
                        if(isset($answer->id_user)){
                            if($user){
                                if($answer->id_user!=$user->id && $user->moderation == 0){
                                    $id_an=$id_answers['answer'];
                                    $dislike_answer = new DislikeAnswer();
                                    $dislike_answer->id_answer = $id_an;
                                    $dislike_answer->id_user = $user->id;
                                    $dislike_answer->id_questions = $id_answers['question'][0];
                                    $dislike_answer->data = strtotime('now');
                                    
                                    $dislike_answer->save(0);
                    
                                    //unset($like_answer);
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

        $answer = DislikeAnswer::find()->where(['id_answer'=>$this->info[0]])->all();
        
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
  
}
