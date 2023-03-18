<?php

namespace app\modules\pers\controllers;

use Yii;
use app\modules\books\models\Books;
use app\modules\pers\models\BookPersPers;
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

class PersController extends Controller
{
   
     //Настройка прав доступа
     public function behaviors()
     {
         return [
             'access' => [
                 'class' => AccessControl::className(),
                 'only' => ['validate','list','save'],
                 'rules' => [
                     [
                         'actions' => ['validate','list','save'],
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
     public function actionValidate()
     {
         $model = new BookPersPers();
         $request = \Yii::$app->getRequest();
         if ($request->isPost && $model->load($request->post())) {
             \Yii::$app->response->format = Response::FORMAT_JSON;
             return ActiveForm::validate($model);
         }
     }


    
    public function actionList(){
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
           \Yii::$app->response->format = Response::FORMAT_JSON;
            $value=$request->post();
            $user = Yii::$app->user->identity;
            $id_pers=0;
            $result= new BookPersPers();
            if(isset($value['id_pers'])){
                $id_pers=$value['id_pers'];
                $result= BookPersPers::find()->where(["id_pers"=>$id_pers])->all();
            }
            return [
                'success' => $this->renderAjax('list', [
                    'models' => $result,
                    "user"=>$user,
                    'BookPersPers'=>new BookPersPers(),
                ])
            ];
        
        }
    }

    public function actionSave(){
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
           \Yii::$app->response->format = Response::FORMAT_JSON;
            $value=$request->post();
            $user = Yii::$app->user->identity;
            if(!isset($value['id_pers']))return ['success' => 1];
            $pers_id=$value['id_pers'];
            if(!isset($value['perspers']))return ['success' => 1];
            $perspers=$value['perspers'];
            //Тут надо все почистить
            BookPersPers::deleteAll('id_pers = :id', [':id' => $pers_id]);
            foreach($perspers as $pers){
                $BookPersPers=new BookPersPers();
                $BookPersPers->id_pers=$pers_id;
                $BookPersPers->to_id_pers=$pers['pers_id'];
                $BookPersPers->name=$pers['name'];
                $BookPersPers->save();
            }
            return ['success' => 1];
        
        }
    }

}
