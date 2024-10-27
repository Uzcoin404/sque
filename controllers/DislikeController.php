<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\User;
use app\models\ViewsAnswers;
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

        $dislike->question_id = 12;
        $dislike->user_id = $user->id;
        $dislike->created_at = strtotime('now');

        $this->DislikeAnswers();

        $dislike->save();
        

    }

    public function actionFilterdislike(){
        // ->where(['question_id'=>$_GET['question_id']])
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $status=0;
        $result="";
        $data = Yii::$app->request->post();
        $sort = $data['sorts'];
        $id = $data['id'];
        $filter = 0;
      
        $answer = Answers::find()->where(['in', 'question_id', $id]);
        if($sort == "DESC"){
            $answer->orderBy('dislikes.dislike_answercount DESC');
            $filter = 1;
        }
        if($sort == "ASC"){
            $answer->orderBy('dislikes.dislike_answercount ASC');
        }
        if($sort == "ALL"){
            $answer->orderBy('number ASC');
        }
        $answerLike = DislikeAnswer::find()
        ->select('id_answer,count(question_id) as dislike_answercount')
        ->groupBy('id_answer');
        $answer->leftJoin(['dislikes'=>$answerLike], 'dislikes.id_answer = answers.id');
        foreach($answer->all() as $question){
            $status=1;
            $result.=$this->renderAjax("@app/widgets/views/answers/_view",["answer"=>$question,"question_id"=>$id, "orderWinner"=>$question->number, 'filter_status'=> $filter]);
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
                $answer_views = ViewsAnswers::find()->where(["id_answer"=>$id_an,"user_id"=>$user->id])->one();
                $dislikes=DislikeAnswer::find()->where(["id_answer"=>$id_an,"user_id"=>$user->id])->one();
                $likes=LikeAnswers::find()->where(["id_answer"=>$id_an,"user_id"=>$user->id])->one();
                if($dislikes || $likes){
                    if($id_answers['status'] == 1){
                        $dislikes->delete();
                        if (!$answer_views->button_click) {
                            $answer_views->delete();
                        }
                        // $answer_views->delete();
                    }
                    return 0;
                } else {
                    $answer=Answers::find()->where(["id"=>$id_an])->one();
                    $question = Questions::find()->where(["id"=>$id_answers['question'][0]])->one();
                    if($question->status == 5){
                        if(isset($answer->user_id)){
                            if($user){
                                if($answer->user_id!=$user->id && $user->moderation == 0){
                                    $id_an=$id_answers['answer'];
                                    $dislikes = new DislikeAnswer();
                                    $dislikes->id_answer = $id_an;
                                    $dislikes->user_id = $user->id;
                                    $dislikes->question_id = $id_answers['question'][0];
                                    $dislikes->created_at = strtotime('now');
                                    
                                    $dislikes->save(0);

                                    if(!$answer_views){
                                        $views = new ViewsAnswers();
                                        $views->id_answer=$id_an;
                                        $views->user_id=$user->id;
                                        $views->type_user=1;
                                        $views->created_at=time();
                                        $views->save(0);
                                    }
                    
                                    //unset($likes);
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
            array_push($this->user_id,$value->user_id);
        }

        foreach($this->user_id as $user){
          
            $user_info  = User::find()->where(['id'=>$user])->one();
            array_push($this->user_info,array("user"=>$user_info->username, "img"=>$user_info->image));

        }

        

        \Yii::$app->response->format = 'json';

        return $this->user_info;
       
    }
  
}
