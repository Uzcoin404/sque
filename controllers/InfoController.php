<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\Info;

// AJAX
use yii\widgets\ActiveForm;

class InfoController extends Controller
{
    public $status = [];
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','list','update'],
                'rules' => [

                    [ 
                        'actions' => ['index','list','update'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],

                    [ 
                        'actions' => ['index','list','update'],
                        'allow' => true,
                        'roles' => ['?'], 
                    ],

                ],
            ],
            
        ];
    }


    public function actionIndex()
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->request;

        $this->status = [
            $request->get('status'),
        ];
        
        \Yii::$app->response->format = 'json';
        
        $info = Info::find()->where(['status'=>$this->status[0]])->one();

        return(
            [
                'text_ru'=>$info->text_ru,
                'text_eng'=>$info->text_eng,
            ]
        );

    }

    public function actionList(){
        $users = Yii::$app->user->identity;

        $model = Info::find()->all();

        if($users && $users->moderation == 1){
            return $this->render(
                'index',
                [
                    "model"=>$model,
                ]
            );
        } else {
            $this->redirect("/");
        }
    }

    public function actionUpdate($slug){
        $model = Info::find()->where(['id'=>$slug])->one();

        if ($model->load(Yii::$app->request->post())) {
            $model->text_ru = $model->text_ru;
            $model->text_eng = $model->text_eng;
            if($model->update(0)){
                return $this->redirect('/');
            }

        }

        return $this->render(
            'update',
            [
                "model"=>$model,
            ]
        );
    }

}
