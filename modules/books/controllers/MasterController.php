<?php

namespace app\modules\books\controllers;

use Yii;
use app\modules\books\models\Books;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
//Модули прав доступа
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DefaultController implements the CRUD actions for Books model.
 */
class MasterController extends Controller
{
     //Настройка прав доступа
     public function behaviors()
     {
         return [
             'access' => [
                 'class' => AccessControl::className(),
                 'only' => ['index','view','create','update','master','idea','scenes','pers','locations','items'],
                 'rules' => [
                     [
                         'actions' => ['index','view','create','update','master','idea','scenes','pers','locations','items'],
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
         $user = Yii::$app->user->identity;
         $active_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one();
        if(!isset($active_book->id)){
            return $this->render(
                'free',
                [
                    "user"=>$user,
                ]
            );
        }
        $book_id=$active_book->id;
        $book=Books::find()->where(
             [
                 "id_user"=>$user->id,
                 'id'=>$book_id,
             ]
         )->orderBy(["id_group"=>"DESC"])->one();
        $user = Yii::$app->user->identity;
        $model=$this->findModel($book_id);
        if ($model->load(Yii::$app->request->post())){
            $model->date_chenge=strtotime('now');
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if(isset($model->imageFile)){
                $model->image=$model->upload();
                $model->imageFile="";
            }
            
            if($model->save()) {
                $this->redirect("/master/idea/".$book_id);
            }
        }
         return $this->render(
             'index',
             [
                 "user"=>$user,
                 "book"=>$book,
             ]
         );

     }

     public function actionIdea($book_id)
     {
        
        $user = Yii::$app->user->identity;
        $book=Books::find()->where(
             [
                 "id_user"=>$user->id,
                 'id'=>$book_id,
             ]
         )->orderBy(["id_group"=>"DESC"])->one();
        $user = Yii::$app->user->identity;
        $model=$this->findModel($book_id);
        if ($model->load(Yii::$app->request->post())){
            $model->date_chenge=strtotime('now');
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if(isset($model->imageFile)){
                $model->image=$model->upload();
                $model->imageFile="";
            }
            
            if($model->save()) {
                $this->redirect("/master/".$book_id."/scenes");
            }
        }
         return $this->render(
             'idea',
             [
                 "user"=>$user,
                 "book"=>$book,
             ]
         );


     }

     protected function findModel($id)
    {
        if (($model = Books::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionScenes($book_id){
        $user = Yii::$app->user->identity;
        return $this->render(
            'scenes',
            [
                "book_id"=>$book_id,
                "user"=>$user,
            ]
        );
    }
    public function actionPers($book_id){
        $user = Yii::$app->user->identity;
        return $this->render(
            'pers',
            [
                "book_id"=>$book_id,
                "user"=>$user,
            ]
        );
    }

    public function actionLocations($book_id){
        $user = Yii::$app->user->identity;
        return $this->render(
            'locations',
            [
                "book_id"=>$book_id,
                "user"=>$user,
            ]
        );
    }
    public function actionItems($book_id){
        $user = Yii::$app->user->identity;
        return $this->render(
            'items',
            [
                "book_id"=>$book_id,
                "user"=>$user,
            ]
        );
    }
    
}
