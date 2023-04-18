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
    public $info = [];
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

    public function DislikeAnswers(){
        
        $request = Yii::$app->request;

        $user=Yii::$app->user->identity;

        $this->info = [
            $request->get('id_answer_dislike'),
        ];
        foreach($this->info as $post){
            foreach($post as $id_answers){
                
                $dislike_answer = new DislikeAnswer();

                $dislike_answer->id_answer = $id_answers;
                $dislike_answer->id_user = $user->id;
                $dislike_answer->data = strtotime('now');
                
                $dislike_answer->save(0);

                //unset($like_answer);
            }
        }

    }
  
}
