<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\Pagination;

use app\models\Complaints;
use app\models\ChangeEmail;
use app\models\Answers;


// AJAX
use yii\widgets\ActiveForm;


class ComplaintsController extends Controller
{
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','moderation','delete'],
                'rules' => [

                    [ 
                        'actions' => ['index','moderation','delete'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],

                ],
            ],
            
        ];
    }

    public function actionIndex()
    {

        $user_id = $_GET['user_id'];
        $answer_id = $_GET['answer_id'];
        $question_id = $_GET['question_id'];
       
        $model = new Complaints();

        $user=Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id=$user_id;
            $model->sender_id=$user->id;
            $model->answer_id=$answer_id;
            $model->question_id=$question_id;
            $model->created_at=time();
           
            if($model->save()){
               
                return $this->redirect('/');
            }
        }

        return $this->render(
            'index',
            [
                "model" => $model,
            ]
        );

    }

    public function actionModeration(){
        $user=Yii::$app->user->identity;
        if($user->moderation == 1){

            $complain = Complaints::find();

            $pages = new Pagination(['totalCount' => $complain->count(), 'pageSize' => 2, 'forcePageParam' => false, 'pageSizeParam' => false]);

            $complain = $complain->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

            return $this->render(
                'moderation',
                [
                    "complain"=>$complain,
                    "pages"=>$pages,
                ]
            );

        } else {
            return $this->redirect('/');
        }
    }

    public function actionDelete($slug){
        $user=Yii::$app->user->identity;
        if($user->moderation == 1){
            Complaints::find()->where(["id"=>$slug])->one()->delete();
            return $this->redirect('/');
        } else {
            return $this->redirect('/');
        }
        
    }
  
}
