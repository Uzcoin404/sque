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
    public $info = [];
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
            foreach($post as $id_answers){

                $like_answer = new LikeAnswers();

                $like_answer->id_answer = $id_answers;
                $like_answer->id_user = $user->id;
                $like_answer->data = strtotime('now');
                
                $like_answer->save(0);
                
            }
        }

    }
  
}
