<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;

use app\modules\books\models\Books;
use app\models\User;
use app\models\ChangeEmail;
// AJAX
use yii\widgets\ActiveForm;


class RegistrationController extends Controller
{
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login','index','logout','registration'],
                'rules' => [
                    [
                        'actions' => ['login','index','registration','activate','restore','captcha'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['login','index','logout','main','registration','changepassword','clearimg'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout','registration','clearimg'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionRestore(){
        $this->layout="//free";
        $model = new SignupForm();
        
            
        if ($model->load(Yii::$app->request->post())) {
            $user =User::find()->where(
                [
                    'email'=>$model->email
                ]
            )->one();
            if(isset($user->id)){
                $model->changePassword($user);
                return $this->render("success_change_password",['name'=>"Готово",'message'=>"Вы изменили пароль. Пароль отправлен Вам на почту."]);
            }
        }
        
        return $this->render(
            'restore',
            [
                "model"=>$model,
            ]
        );
    }
    public function actionActivate($hash){
        $user =User::find()->where(
            [
                'accessToken'=>$hash
            ]
        )->one();
        $this->layout="//free";
        if(!isset($user->id)) return $this->render("error",['name'=>"Ошибка",'message'=>"Не удалось активировать учётную запись"]);
        $user->status=1;
        $user->end_at=strtotime('+20 day');
        if(!$user->save()){
            return $this->render("error",['name'=>"Ошибка",'message'=>"Не удалось активировать учётную запись"]);
        }
        return $this->render("activated");
   
    }
    public function actionChangeemail($hash){
        echo 1; exit;
        $ChangeEmail=ChangeEmail::find()->where(
            [
                "status"=>1,
                "hash"=>$hash
            ]
        )->one();
        $this->layout="//free";
        if(!isset($ChangeEmail->id)) return $this->render("error",['name'=>"Ошибка",'message'=>"Не удалось сменить почту"]);
        $user=User::find()->where(
            [
                'status'=>1,
                'id'=>$ChangeEmail->user_id,
            ]
        )->one();
        if(!isset($user->id)) return $this->render("error",['name'=>"Ошибка",'message'=>"Не удалось сменить почту"]);
        $user->email=$ChangeEmail->email;
        if(!$user->save()){
            return $this->render("error",['name'=>"Ошибка",'message'=>"Не удалось сменить почту"]);
        }
        return $this->render("error",['name'=>"Изменение принято",'message'=>"Вы изменили свою почту"]);
   }



    //Авторизация
    public function actionLogin()
    {
        //////////////////////////////////////////////////////////////
        //if (Yii::$app->user->isGuest) {
         //   return $this->render('index');
        //}
        //////////////////////////////////////////////////////////////
        $this->layout="//free";
        if (!Yii::$app->user->isGuest) {
           return $this->goHome();
        }
     
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    //Выход
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegistration(){
        $this->layout="//free";
        $model = new SignupForm();
      
        if ($model->load(Yii::$app->request->post())) {
          
            if ($user = $model->signup()) {
               
                if (Yii::$app->getUser()->login($user)) {
                    return $this->render("ok");
                }else{
                    return $this->render("error",['name'=>"Ошибка регистрации",'message'=>"Такой логин/email уже есть в системе"]);
                }
            }else{
                return $this->render("error",['name'=>"Ошибка регистрации",'message'=>"Проверьте данные и попробуйте еще раз."]);
            }
        }
 
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionChangepassword(){
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isPost) {
            
            $value=$request->post();
            $user =User::find()->where(
                [
                    'accessToken'=>$value['token']
                ]
            )->one();
            if(isset($user->id)){
                $model = new SignupForm();
                $model->changePassword($user);
                return ['success' => 1];
            }
            return ['success' => 0];
        }
        return ['success' => 0];
    }

    
    public function actionClearimg(){
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isPost) {
            
            $value=$request->post();
            $user =User::find()->where(
                [
                    'accessToken'=>$value['token']
                ]
            )->one();
            $user->image="";
            if($user->save()){ 
                return ['success' => 1];
            }else{
                return ['success' => $user->getErrors()];
            }
            return ['success' => 0];
            
        }
        return ['success' => 0];
    }
  
}
