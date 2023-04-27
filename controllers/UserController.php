<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\Queue;
use app\models\User;
use app\models\ChangeEmail;

// AJAX
use yii\widgets\ActiveForm;
class UserController extends Controller
{
    public $info = [];
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','get','update','download','status'],
                'rules' => [

                    [
                        'actions' => ['index','get','update','download','status'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            
        ];
    }

   
    //Главный экран
    public function actionIndex()
    {
        
        //$this->layout="/none";
        $model= Yii::$app->user->identity;
        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if($model->imageFile){
                $model->image=$model->upload();
                $model->imageFile="";
            }
            if($model->save()){
                $this->redirect("/main");
            }
            
        }

        return $this->render(
            'index',
            [
                'model'=>$model,
            ]
        );
    }
    
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdate()
    {
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $user=Yii::$app->user->identity;
        $model=$this->findModel($user->id);
        
            if ($request->isPost && $model->load($request->post())) {
                
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if(MD5($model->email)!=MD5($user->email)){
                    $ChangeEmail=new ChangeEmail();
                    $ChangeEmail->email=$model->email;
                    $ChangeEmail->user_id=$user->id;
                    $ChangeEmail->status=1;
                    $ChangeEmail->date=strtotime(date('Y-m-d 00:00:00'));
                    $ChangeEmail->hash=MD5($ChangeEmail->date."user".$user->id."".date("Y-m-d H:i:s"));
                    if($ChangeEmail->save()){
                        return ['success' =>$this->sendEmail($ChangeEmail->email,"Смена рабочей почты",$ChangeEmail->getEmailText())];
                    }else{
                        return ['success' =>$ChangeEmail->getErrors()]; 
                    }
                    $model->email=$user->email;
                }
                if(isset($model->imageFile)){
                    $model->image=$model->upload();
                    $model->imageFile="";
                }
              
                if($model->save()){
                    $this->redirect('/');
                }
            }
        
        
        return $this->redirect('/');
    
    }

    public function actionRead(){
        return $this->render(
            'read',
        );
    }

    public function actionStatus(){

        $user = Yii::$app->user->identity;

        $request = Yii::$app->request;

        $this->info = [
            $request->get('status'),
        ];

        $user->read = $this->info[0];

        return $user->update(0);
        
    }
  
    public function actionGet(){
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isPost) {
            $this->layout="/none";
            $model= Yii::$app->user->identity;
            
            return [
                'success' =>  $this->renderAjax('_form_update', [
                                'model' => $model,
                            ])
            ];
           
        }
        return ['success' => 0];
    }


    public function sendEmail($to,$subject,$body){
        Yii::$app->mailer->compose()
        ->setTo([$to])
        ->setFrom("noreply@my-novel.online")
        ->setSubject($subject)
        ->setHtmlBody($body)
        ->send();

        return true;
    }

    public function actionDownload(){
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
     
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $user=Yii::$app->user->identity;
            $Downloadqueue=new Queue();
            $Downloadqueue->id_model=$user->id;
            $Downloadqueue->type="USER_DOWNLOAD";
            $Downloadqueue->status=1;
            if($Downloadqueue->save()){
                return [
                    "success"=>1,
                ];
    
            }
            //Получить все активные книги
            //создать папки
            //Получить персонажей 
            //Получить предметы
            //Получить локации
            //Получить Тексты
            //Получить заметки
            //Архивация
        }
        return [
            "success"=>0,
        ];
    }
}
