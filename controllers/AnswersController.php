<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\Answers;
use app\models\User;
use app\models\ChangeEmail;


// AJAX
use yii\widgets\ActiveForm;


class AnswersController extends Controller
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

                ],
            ],
            
        ];
    }

    public function actionCreate($slug)
    {
        
        $model = new Answers();

        if ($model->load(Yii::$app->request->post())) {
            $user = Yii::$app->user->identity;
            $model->id_user=$user->id;
            $model->id_questions=$slug;
            $model->data=strtotime('now');
            if($this->CheckUser($slug)){
                return $this->redirect('/questions/view/'.$slug.'');
            }
            if($model->save()){
                return $this->redirect('/questions/view/'.$slug.'');
            }
        }

        return $this->render(
            'create',
            [
                "model"=>$model,
            ]
        );
    }

    public function CheckUser($slug)
    {
        $user=Yii::$app->user->identity;

        $Answers=Answers::find()->where(["id_questions"=>$slug,"id_user"=>$user->id])->one();

        if(!isset($Answers)){
            return 0;
        } else {
            return 1;
        }
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
