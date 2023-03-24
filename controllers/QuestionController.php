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
                'only' => ['index','create','update','myquestions'],
                'rules' => [

                    [ 
                        'actions' => ['index','create','update','myquestions'],
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

    //Внутреннея страница

    public function actionView($slug){
        $questions = Questions::find()->where(["id"=>$slug])->all();
        return $this->render(
            'view',
            [
                "questions"=>$questions,
            ]
        );
    }

    // Страница моих вопросов

    public function actionMyquestions(){
        $user=Yii::$app->user->identity;
        $questions = Questions::find()->where(["owner_id"=>$user->id])->all();
        return $this->render(
            '_myquestion',
            [
                "questions"=>$questions,
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
            $model->grand='Россия';
            if($model->save()){
                return $this->redirect('/questions/view/'.$model->id.'');
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
