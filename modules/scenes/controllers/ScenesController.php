<?php

namespace app\modules\scenes\controllers;

use Yii;
use app\modules\books\models\Books;
use app\modules\scenes\models\Bookscenes;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

//Модули прав доступа
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
// AJAX
use yii\web\Response;
use yii\widgets\ActiveForm;

class ScenesController extends Controller
{
   
     //Настройка прав доступа
     public function behaviors()
     {
         return [
             'access' => [
                 'class' => AccessControl::className(),
                 'only' => ['list'],
                 'rules' => [
                     [
                         'actions' => ['list'],
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
    


    
    public function actionList(){
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $user = Yii::$app->user->identity;
 
            $active_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one();
            $BookScenes=BookScenes::find()->where(["id_book"=>$active_book->id,'status'=>1])->orderBy(["sort"=>"ASC"])->all();
            
            return ['success' =>$this->renderAjax(
                'list',
                [
                    "user"=>$user,
                    "models"=>$BookScenes,
                  ]
              )
            ];
        
        }
    }

}
