<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\User;
use app\models\Chat;
use app\models\ChangeEmail;


// AJAX
use yii\widgets\ActiveForm;


class ChatController extends Controller
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

        $user=Yii::$app->user->identity;



        $model = new Chat();

        if ($model->load(Yii::$app->request->post())) {
            $model->sender_id=$user->id;
            $model->recipient_id=$id;
            $model->data=strtotime('now');
            $model->status=0;
            if($model->save()){
                return $this->redirect('/chat');
            }
        }
     
        return $this->render(
            'index',
            [
                "chats" => Chat::find()->where(['sender_id'=>$user->id])->all(),
                "admin" => $id,
                "model" => $model,
            ]
        );



    }


  
}
