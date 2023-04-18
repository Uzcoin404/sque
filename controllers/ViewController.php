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
use app\models\ChangeEmail;


// AJAX
use yii\widgets\ActiveForm;


class ViewController extends Controller
{
    //Настройка прав доступа
    public $info = [];
    public $type_user_id = 0;
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

        $this->info = [
            $request->get('status_view'),
        ];

        if(isset(\Yii::$app->user->identity->id)){
            $user->id=\Yii::$app->user->identity->id;
            $this->type_user_id=1;
        }else{
            $user->id=Yii::$app->session->getId();
            $this->type_user_id=0;
        }

            foreach($this->info as $post){
               
                foreach($post as $view){
                    $Views=ViewsAnswers::find()->where(["id_answer"=>$view,"id_user"=>$user->id])->one();
                   
                    if(!isset($Views->id)){

                        $Views = new ViewsAnswers();
                        
                        $Views->id_answer=$view;
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
