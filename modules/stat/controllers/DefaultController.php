<?php

namespace app\modules\stat\controllers;
use Yii;
use app\modules\books\models\Books;
use app\modules\scenes\models\BookScenes;
use app\modules\text\models\BookText;
use yii\web\Controller;
//Модули прав доступа
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


// AJAX
use yii\web\Response;
use yii\widgets\ActiveForm;

class DefaultController extends Controller
{
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','create','update','getstatday'],
                'rules' => [
                    [
                        'actions' => ['index','view','create','update','getstatday'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    
                ],
            ],
        ];
    }
    public function actionIndex()
    {
     
           return $this->render('index',['model'=>new BookText()]);

    }

    public function actionGetstatday(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            if (Yii::$app->user->isGuest) {
                return [
                    'success' => BookText::getCountWordsPerDay(),
                ];
            }
            $user = Yii::$app->user->identity;
            $end_day=round(($user->end_at-$user->create_at)/86400);
            if($end_day==10 || $end_day==5 || $end_day==3 || $end_day==2 || $end_day==1){
                return [
                    'success' => BookText::getCountWordsPerDay(),
                    'end_day'=>"Осталось: ".$end_day." дней."
                ];
            }
            return [
                'success' =>BookText::getCountWordsPerDay() ,
            ];
                

        }
        return 0;
    }
}
