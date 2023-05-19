<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\Pagination;

use app\models\Answers;
use app\models\Questions;
use app\models\User;
use app\models\ChangeEmail;


// AJAX
use yii\widgets\ActiveForm;


class AnswersController extends Controller
{
    public $postans = '';
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update','myanswers','myanswersview'],
                'rules' => [

                    [ 
                        'actions' => ['index','create','update','myanswers','myanswersview'],
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
                return $this->redirect('/');
            }

        }
        $question=Questions::find()->where(['id'=>$slug])->one();
        if(!$question)  return $this->redirect('/questions/view/'.$slug.'');
        return $this->render(
            'create',
            [
                "model"=>$model,
                "question"=>$question,
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

    public function actionMyanswers()
    {

        $user=Yii::$app->user->identity;

        $answer = Answers::find()->where(['id_user'=>$user->id]);

        $pages = new Pagination(['totalCount' => $answer->count(), 'pageSize' => 5, 'forcePageParam' => false, 'pageSizeParam' => false]);

        $answer = $answer->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        
        return $this->render(
            '_myanswers',
            [
                'answer'=>$answer,
                "pages"=>$pages,
            ]
        );
        

    }

    public function actionMyanswersview($slug){
        $questions = Questions::find()->where(["id"=>$slug])->all();
        return $this->render(
            'view',
            [
                "questions"=>$questions,
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
