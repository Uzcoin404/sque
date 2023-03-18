<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\Questions;
use app\models\User;
use app\models\ChangeEmail;

// AJAX
use yii\widgets\ActiveForm;
class QuestionController extends Controller
{
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update'],
                'rules' => [

                    [ 
                        'actions' => ['index','create','update'],
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

   
    //Главный экран
    public function actionIndex()
    {
        
        return $this->render(
            'index',
            [
                "questions"=>Questions::find()->where(["status"=>[4,5,6,7]])->orderBy(["data"=>SORT_ASC])->all(),
            ]
        );
    }

    public function actionCreate()
    {
        
        $model = new Questions();

        if ($model->load(Yii::$app->request->post())) {
            $user = Yii::$app->user->identity;
            $model->owner_id=$user->id;
            $model->data=strtotime('now');
            $model->status=1;
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        }

        return $this->render(
            'create',
            [
                "model"=>$model,
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
        
    }
  
    
}
