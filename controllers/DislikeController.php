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
use app\models\ChangeEmail;


// AJAX
use yii\widgets\ActiveForm;


class DislikeController extends Controller
{
    public $key_dislike="SDbB23X3@FGLbisk%";
    public $key_dislike_answer = "KmbD4ASdgbla@FGLbiskFzxb";
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
        $dislike = new Dislike();
        $request = Yii::$app->request;

        $user=Yii::$app->user->identity;

        $dislike->id_questions = $slug;
        $dislike->id_user = $user->id;
        $dislike->data = strtotime('now');

        $dislike_status = $request->get('dislike');

        if($dislike_status == $this->key_dislike_answer){
            $this->DislikeAnswers($slug);
        }
        
        if($this->CheckUser($slug)){
            return $this->redirect('/questions/view/'.$slug.'');
        }
        if($dislike_status == $this->key_dislike){
            if($dislike->save()){
                return $this->redirect('/questions/view/'.$slug.'');
            }
        }
        

    }

    public function DislikeAnswers($slug){

        $dislike_answer = new DislikeAnswer();

        $request = Yii::$app->request;

        $user=Yii::$app->user->identity;

        $id = $request->get('id_answer');

        $dislike_answer->id_questions = $slug;
        $dislike_answer->id_user = $user->id;
        $dislike_answer->data = strtotime('now');
        $dislike_answer->id_answer = $id;

        if($this->CheckUserAnswer($id)){
            return $this->redirect('/questions/view/'.$slug.'');
        }

        if($dislike_answer->save()){
            return $this->redirect('/questions/view/'.$slug.'');
        }

    }

    public function CheckUserAnswer($id)
    {
        $user=Yii::$app->user->identity;

        $dislike_user=DislikeAnswer::find()->where(["id_answer"=>$id,"id_user"=>$user->id])->one();

        if(!isset($dislike_user)){
            return 0;
        } else {
            return 1;
        }
    }

    public function CheckUser($slug)
    {
        $user=Yii::$app->user->identity;

        $dislike_user=Dislike::find()->where(["id_questions"=>$slug,"id_user"=>$user->id])->one();

        if(!isset($dislike_user)){
            return 0;
        } else {
            return 1;
        }
    }
  
}
