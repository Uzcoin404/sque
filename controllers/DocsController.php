<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\Pagination;

use app\models\Docs;

// AJAX
use yii\widgets\ActiveForm;


class DocsController extends Controller
{
 
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view','index','add'],
                'rules' => [

                    [ 
                        'actions' => ['index','add','view'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],
                    [ 
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['?'], 
                    ],

                ],
            ],
            
        ];
    }

    public function actionView($slug){
       $Doc=Docs::find()->where(["href"=>$slug,"status"=>1])->one();
       if(!isset($Doc->id)){
            return $this->redirect("/");
       }else{
            return $this->render("view",["html"=>$Doc->text,'href'=>$slug]);
       }
      
    }

    public function actionIndex(){
        $model = new Docs();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            Docs::updateAll(['status' => 0],['href'=>$model->href]);
            $model->upload($model->href);
            $model->user= Yii::$app->user->identity->id;
            $model->created_at=strtotime('now');
            $model->status=1;
            $model->save();  
        }
        return $this->render("index",["Docs"=>$model]);
    }


  
}
