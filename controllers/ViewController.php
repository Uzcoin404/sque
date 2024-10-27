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
    public $question_id = [];
    public $btn_click = [];
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

        $moderation = 0;

        if($user){
            $moderation = $user->moderation;
        }

        

        $this->info = [
            $request->get('status_view'),
        ];

        $this->question_id = [
            $request->get('question_id'),
        ];

        $this->btn_click = [
            $request->get('button_click'),
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
                       
                       
                            $questions = Questions::find()->where(['id'=>$this->question_id[0][0]])->one();
                            $Views=ViewsAnswers::find()->where(["id_answer"=>$post,"user_id"=>$user->id])->one();
                    
                            if($questions->status < 6){
                                if($questions->status == 5){
                                        
                                        if(!isset($Views->id)){
                                            if($this->btn_click[0] == 1){
                                                $Views = new ViewsAnswers();
                                                $Views->id_answer=$post;
                                                $Views->type_user=$this->type_user_id;
                                                $Views->user_id=$user->id;
                                                $Views->created_at=time();
                                                $Views->isNewRecord=1;
                                                $Views->button_click=$this->btn_click[0];
                                                $Views->save(0);
                                            } else {
                                                $Views = new ViewsAnswers();
                                                $Views->id_answer=$post;
                                                $Views->type_user=$this->type_user_id;
                                                $Views->user_id=$user->id;
                                                $Views->created_at=time();
                                                $Views->isNewRecord=1;
                                                $Views->save(0);
                                            }

                                        
                                            //unset($likes);
                                        } else {
                                            if($this->btn_click[0] == 1){
                                                $Views->button_click=$this->btn_click[0];
                                                $Views->update(0);
                                            } else {
                                                $Views->button_click=0;
                                                $Views->update(0);
                                            }
                                        }
                    
                                }    
                            }               
                    }

            }

    }
  
    
}
