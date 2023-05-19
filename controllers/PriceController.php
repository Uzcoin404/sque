<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\Price;


// AJAX
use yii\widgets\ActiveForm;


class PriceController extends Controller
{
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','user'],
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
        $user = Yii::$app->user->identity;
        if($user->moderation == 1){
            $model = Price::find()->where(['id'=>1])->one();

            if ($model->load(Yii::$app->request->post())) {
            
                $model->money = $model->money;
    
                if($model->update(0)){
                    return $this->redirect(
                        '/',
                    );
                }
            }
    
            return $this->render(
                'index',
                [
                    "model"=>$model,
                ]
            );
        } else {
            $this->redirect('/');
        }

    }

  
}
