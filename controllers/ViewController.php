<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\ViewsAnswers;
use app\models\User;
use app\models\Questions;
use app\models\ChangeEmail;


// AJAX
use yii\widgets\ActiveForm;


class ViewController extends Controller
{
    //Настройка прав доступа
    public $info = [];
    public $type_user_id = 0;
    public $id_question = [];
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
        
        $request = Yii::$app->request;

        $user=Yii::$app->user->identity;

        $moderation = '';

        if($user){
            $moderation = $user->moderation;
        }

        

        $this->info = [
            $request->get('status_view'),
        ];

        $this->id_question = [
            $request->get('id_question'),
        ];

        if(isset(\Yii::$app->user->identity->id)){
            $user->id=\Yii::$app->user->identity->id;
            $this->type_user_id=1;
        }else{
            $user->id=Yii::$app->session->getId();
            $this->type_user_id=0;
        }



            foreach($this->info as $post){
                
                    if(!$moderation){
                        if($questions->status != 6){
                            $questions = Questions::find()->where(['id'=>$this->id_question[0][0]])->one();
                            $Views=ViewsAnswers::find()->where(["id_answer"=>$post,"id_user"=>$user->id])->one();

                            if($questions->status < 6 && $questions->status > 4){
                                
                                    if(!isset($Views->id)){
                                
                                        $Views = new ViewsAnswers();
                                        
                                        $Views->id_answer=$post;
                                        $Views->type_user=$this->type_user_id;
                                        $Views->id_user=$user->id;
                                        $Views->data=strtotime("now");
                                        $Views->isNewRecord=1;
                                        $Views->save(0);
                                    
                                        //unset($like_answer);
                                    }
                
                            }    
                        }               
                    }

            }

    }
  
    
}
