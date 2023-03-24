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
    public $key_like="SDbB23X3@FGLbisk%";
    public $key_like_answer = "KmbD4ASdgbla@FGLbiskFzxb";
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [

                    [ 
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],

                ],
            ],
            
        ];
    }

    public function actionIndex($slug)
    {
        $like = new Like();
        $request = Yii::$app->request;

        $user=Yii::$app->user->identity;

        $like->id_questions = $slug;
        $like->id_user = $user->id;
        $like->data = strtotime('now');

        $like_status = $request->get('like');

        
        if($like_status == $this->key_like_answer){
            $this->LikeAnswers($slug);
        }

        if($this->CheckUserPost($slug)){
            return $this->redirect('/questions/view/'.$slug.'');
        }
        if($like_status == $this->key_like){
            if($like->save()){
                return $this->redirect('/questions/view/'.$slug.'');
            }
        }

        
    }

    public function LikeAnswers($slug){

        $like_answer = new LikeAnswers();

        $request = Yii::$app->request;

        $user=Yii::$app->user->identity;

        $id = $request->get('id_answer');

        $like_answer->id_questions = $slug;
        $like_answer->id_user = $user->id;
        $like_answer->data = strtotime('now');
        $like_answer->id_answer = $id;

        if($this->CheckUserAnswer($id)){
            return $this->redirect('/questions/view/'.$slug.'');
        }

        if($like_answer->save()){
            return $this->redirect('/questions/view/'.$slug.'');
        }

    }

    public function CheckUserPost($slug)
    {
        $user=Yii::$app->user->identity;

        $like_user=Like::find()->where(["id_questions"=>$slug,"id_user"=>$user->id])->one();

        if(!isset($like_user)){
            return 0;
        } else {
            return 1;
        }
    }

    public function CheckUserAnswer($id)
    {
        $user=Yii::$app->user->identity;

        $like_user=LikeAnswers::find()->where(["id_answer"=>$id,"id_user"=>$user->id])->one();

        if(!isset($like_user)){
            return 0;
        } else {
            return 1;
        }
    }
  
}
