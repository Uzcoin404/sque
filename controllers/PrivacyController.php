<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

// AJAX
use yii\widgets\ActiveForm;


class PrivacyController extends Controller
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

                    [ 
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'], 
                    ],

                ],
            ],
            
        ];
    }

    public function actionIndex()
    {
        return $this->render(
            'index',
        );
    }

  
}
