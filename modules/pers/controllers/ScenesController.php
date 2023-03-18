<?php

namespace app\modules\pers\controllers;

use Yii;
use app\modules\books\models\Books;
use app\modules\pers\models\BookPersScenes;
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
                 'only' => ['validate','list','from','create','delete'],
                 'rules' => [
                     [
                         'actions' => ['validate','list','from','create','delete'],
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
         $model = new BookPersScenes();
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
            $result= BookPersScenes::find()->where(["id_user"=>$user->id,'id_scenes'=>$value['scene_id']])->all();
            $pers=[];
            FOREACH($result as $r){
                $pers[$r->per->id]=$r->per->name;
            }
            return [
                'success' => $this->renderAjax('list', [
                    'models' => $result,
                    "user"=>$user,
                    "id_scenes"=>$value['scene_id'],
                ]),
                'result'=>$pers
            ];
        
        }
    }

    public function actionForm(){
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isPost) {
            $this->layout="/none";
            $user = Yii::$app->user->identity;
            $value=$request->post();
            $model = new BookPersScenes();

            return [
                'success' =>  $this->renderAjax('_form_create', [
                                'model' => $model,
                                "user"=>$user,
                                "scenes"=>$value['id_scene'],
                            ])
            ];
           
        }
        return ['success' => 0];
    }
    public function actionCreate($id_scene)
    {
        
        $user = Yii::$app->user->identity;
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $value=$request->post();
        if(isset($value['BookPersScenes']['id_pers'])){
            foreach($value['BookPersScenes']['id_pers'] as $id_pers){
                $model = new BookPersScenes();
                $model->id_user=$user->id;
                $model->id_scenes=$id_scene;
                $model->id_pers=$id_pers;
                $model->save();
            }
        }
        return ['success' => 0];
    
    }

    
    public function actionDelete(){
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            $value=$request->post();
            $id_item=$value['id_item'];
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $user = Yii::$app->user->identity;
            BookPersScenes::deleteAll('id = :id and id_user = :id_user', [':id' => $id_item, ":id_user"=>$user->id]);
            return ['success' => 1];
            
           
            
        }
    }
}
