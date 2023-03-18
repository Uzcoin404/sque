<?php

namespace app\modules\books\controllers;

use Yii;
use app\modules\books\models\Books;
use app\modules\books\models\BookGroups;
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

class GroupsController extends Controller
{
   
     //Настройка прав доступа
     public function behaviors()
     {
         return [
             'access' => [
                 'class' => AccessControl::className(),
                 'only' => ['create','update','delete','form','list'],
                 'rules' => [
                     [
                         'actions' => ['create','update','delete','form','list'],
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
         $model = new BookGroups();
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
            $result= BookGroups::find()->where(["id_user"=>$user->id,'status'=>1])->all();
            return [
                'success' => $this->renderAjax('list', [
                    'models' => $result,
                    "user"=>$user,
                ]),
            ];
        
        }
    }
    public function actionCreate()
    {
        $model = new BookGroups();
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isPost && $model->load($request->post())) {
                $user = Yii::$app->user->identity;
                $model->id_user=$user->id;
                $model->status=1;
                    return ['success' =>$model->save()];
            }
        
        
        return ['success' => 0];
    
    }

    

    public function actionUpdate($id)
    {
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model =$this->findModel($id);
            if ($request->isPost && $model->load($request->post())) {
                $user = Yii::$app->user->identity;
                return ['success' =>$model->save()];
            }
        
        
        return ['success' => 0];
    
    }

    private function findAndDelete($group_id){
        $elements=Books::find()->where(['status'=>1])->andWhere(['like', 'id_group', $group_id])->all();
        foreach($elements as $element){
            $element->group=str_replace($group_id."|","",$element->group);
            $element->id_group=$element->findGroup();
            $element->save(); 
        }
        return 1;
    }

    public function actionDelete(){
        
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $value=$request->post();
            if(isset($value['id']) && $value['id']>0){
                $Books=$this->findModel($value['id']);
                $Books->status=0;
                if($Books->save()){
                    if($this->findAndDelete($value['id'])){
                        return ['success' => 1];
                    }
                   
                }
            }
            return [];
            
        }
    }


    public function actionForm(){
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isPost) {
            $this->layout="/none";
            $user = Yii::$app->user->identity;
            $value=$request->post();
            $model = new BookGroups();
            
            if(isset($value['id']) && $value['id']>0){
                $model = $this->findModel($value['id']);
                return [
                    'success' =>  $this->renderAjax('_form_update', [
                                    'model' => $model,
                                    "user"=>$user,
                                ])
                ];
            }

            return [
                'success' =>  $this->renderAjax('_form_create', [
                                'model' => $model,
                                "user"=>$user,
                            ])
            ];
           
        }
        return ['success' => 0];
    }

    protected function findModel($id)
    {
        if (($model = BookGroups::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
