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
use app\models\LikeAnswers;
use app\models\ChangeEmail;


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
                        'actions' => ['index','block'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],

                    [ 
                        'actions' => ['block'],
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

        $like_answer = new LikeAnswers();

        $request = Yii::$app->request;

        $user=Yii::$app->user->identity;

        $this->info = [
            $request->get('id_answer_like'),
        ];
        
        foreach($this->info as $post){
          
            foreach($post as $like){
                $like_answer = new LikeAnswers();

                $like_answer->id_answer = $like['answer'];
                $like_answer->id_questions = $like['question'];
                $like_answer->id_user = $user->id;
                $like_answer->data = strtotime('now');
                
                $like_answer->save(0);
                
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
  
}
