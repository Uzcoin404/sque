<?php

namespace app\modules\pers\controllers;

use Yii;
use app\modules\books\models\Books;
use app\modules\pers\models\BookPers;
use app\modules\pers\models\BookPersPers;
use app\modules\pers\models\BookPersScenes;
use app\modules\pers\models\BookPersGroup;
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

class DefaultController extends Controller
{
   
     //Настройка прав доступа
     public function behaviors()
     {
         return [
             'access' => [
                 'class' => AccessControl::className(),
                 'only' => ['index','filter','create','update','master','form','validate','delete','copy','active','sort','clearimg'],
                 'rules' => [
                     [
                         'actions' => ['index','filter','create','update','master','form','validate','delete','copy','active','sort','clearimg'],
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
         $model = new BookPers();
         $request = \Yii::$app->getRequest();
         if ($request->isPost && $model->load($request->post())) {
             \Yii::$app->response->format = Response::FORMAT_JSON;
             return ActiveForm::validate($model);
         }
     }

     private function GenerationGroups($book,$filter_element=false,$all_groups=false){
        $result=[];
       
        Foreach($filter_element as $element){
            foreach($element->id_group as $group){
                if($group){
                if(isset($result[$group])){
                    array_push($result[$group]["elements"],$element);
                }else{
                    if($all_groups){
                        $find= in_array($group, $all_groups);
                        if($find)
                        $result[$group]=[
                            "group"=>$element->getGroup($group),
                            "elements"=>[$element]
                        ];
                    }else{
                        $result[$group]=[
                            "group"=>$element->getGroup($group),
                            "elements"=>[$element]
                        ];
                    }
                }
                }
                
            }
        }      
        $groups=[];
        if($all_groups){
            $groups=BookPersGroup::find()->where(['id_book'=>$book,'id'=>$all_groups])->orderBy(['name'=>SORT_ASC])->all(); 
           
        }else{
            $groups=BookPersGroup::find()->where(['id_book'=>$book])->orderBy(['name'=>SORT_ASC])->all();
        }
        foreach($groups as $group){
            if(!isset($result[$group->id])){
                $result[$group->id]=[
                    "group"=>$group,
                    "elements"=>[]
                ];
            }
        } 
        return $result;
     }


     public function actionFilter()//BookPers
     {
         
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            $all_groups=false;
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $this->layout="//none";
            $value=$request->post();
            $user = Yii::$app->user->identity;
            $active_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one();
            if(!isset($active_book->id)) 
                return ['success' => 0];
            $models=BookPers::find()->where(["id_book"=>$active_book->id,'status'=>1]);

            /*** FILTERS ***/
            if(isset($value['filter_items_name'])){
                $models->andWhere(['like', 'nickname', $value['filter_items_name']]);
            }
            if(isset($value['filter_items_groups'])){
                $all_groups=[];
                $filter_group=["OR"];
                foreach($value['filter_items_groups'] as $group){
                    $all_groups[]=$group;
                    array_push(
                        $filter_group,
                        [
                            'like',
                            'id_group',
                            $group,
                        ]
                    );
                }
                $models->andFilterWhere($filter_group);
                //$models->andWhere(['like','id_group', $value['filter_items_groups']]);
            }
            /*** FILTERS ***/
            

            $models=$models->orderBy(["id_group"=>SORT_ASC,"sort"=>SORT_ASC])->all();
            $groups=$this->GenerationGroups($active_book->id,$models,$all_groups);

            return [
                'success' =>$this->renderAjax(
                    'render',
                    [
                        "groups"=>$groups,
                    ]
                ),
                'id'=>$active_book->id,
                'name'=>$active_book->name
            ];
        }
        return ['success' => 0];
     }



    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
         return $this->render(
             'index',
             [
                 "user"=>$user,

             ]
         );
    }

    protected function findModel($id)
    {
        if (($model = BookPers::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionFrom(){
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isPost) {
            $this->layout="/none";
            $user = Yii::$app->user->identity;
            $value=$request->post();
            $model = new BookPers();
            if(isset($value['id']) && $value['id']>0){
                $model = $this->findModel($value['id']);
                return [
                    'success' =>  $this->renderAjax('_form_update', [
                                    'model' => $model,
                                    "user"=>$user,
                                ])
                ];
            }
           
            $model->id_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
            if(isset($value['group_id']) && $value['group_id']>0){
                $model->group=$value['group_id'];
                $model->id_group=$value['group_id'];
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

    public function actionCreate()
    {
        $model = new BookPers();
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isPost && $model->load($request->post())) {
                $user = Yii::$app->user->identity;
                //$model->id_user=$user->id;
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if($model->imageFile){
                    $model->image=$model->upload();
                }
                

                
                if (isset($model->image)) {
                    $model->imageFile="";
                }
                $model->sort=$model->getMaxSort();
                    $model->id_group=$model->findGroup();
                    $model->id_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
                    //$model->save();
                    //18-10-2021
                    if($model->save()){
                        return [
                            'success' => 1, 
                            "reload" =>1,
                            "element"=>$model->id, 
                            "html"=>  $this->renderAjax('_view', [
                                'element' => $model,
                                'dataIndex'=>$model->sort
                            ])
                        ]; 
                    }
                    return ['success' => 0  ]; 
                    //18-10-2021
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
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                if(isset($model->imageFile)){
                    $model->image=$model->upload();
                    $model->imageFile="";
                }
                $model->id_group=$model->findGroup();
                $reload_page=0;
                if($model->group!=$model->id_group){
                    $reload_page=1;
                }
                 //if($model->save()){ 
                //    return ['success' => $model->id];
               // }
                //18-10-2021
                if($model->save()){
                    return [
                        'success' => $model->id, 
                        "reload" =>$reload_page,
                        "element"=>$model->id, 
                        "html"=>  $this->renderAjax('_element', [
                            'element' => $model,
                        ])
                    ]; 
                }
                return ['success' => 0  ]; 
                //18-10-2021
            }
        
        
        return ['success' => 0];
    
    }


    public function actionDelete(){
        
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $value=$request->post();
            $Books=$this->findModel($value['id']);
            $Books->status=0;
            $Books->id_group=$Books->findGroup();
            if($Books->save()){
                return ['success' => 1];
            }
            return [print_r($Books->getErrors(),1)];
            
        }
    }
    public function actionCopy(){
        
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $value=$request->post();
            $Books=$this->findModel($value['id']);
            $data = $Books->attributes;
            $new_item= new BookPers();
            $new_item->setAttributes($data);
            $new_item->id_group=$Books->group;
            if($new_item->save()){ 
                // return ['success' => 1];
                 //18-10-2021
                 return [
                     'success' => $new_item->id, 
                     "element"=>$new_item->id, 
                     "html"=>  $this->renderAjax('_view', [
                         'element' => $new_item,
                         'dataIndex'=>$new_item->sort
                     ])
                 ]; 
                 //18-10-2021
             }
             return ['success' => 0];
            
        }
    }

    public function actionActive($books_id){
        
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $Books=$this->findModel($books_id);
            $Books->status=1;
            $Books->id_group=$Books->findGroup();
            if($Books->save()){
                return ['success' => 1];
            }
            return [];
            
        }
    }

    public function actionSort(){
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $user = Yii::$app->user->identity;
            $value=$request->post();
            $id=(int)$value['id'];
            $old=(int)$value['old'];
            $new=(int)$value['new']; 
            if($old > $new){ 
                BookPers::updateAll(
                    [
                        "sort"=>new \yii\db\Expression('`sort` + 1'),
                    ],
                    "id_book=:id_book AND sort >=:NEW and sort < :OLD",
                    [
                        ":id_book"=>Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id,
                        ":NEW"=>$new,
                        ":OLD"=>$old
                    ]
                   
                );
            
            }
            if($old < $new){ 
                BookPers::updateAll(
                    [
                        "sort"=>new \yii\db\Expression('`sort` - 1'),
                    ],
                    "id_book=:id_book AND sort <=:NEW and sort >=:OLD",
                    [
                        ":id_book"=>Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id,
                        ":NEW"=>$new,
                        ":OLD"=>$old
                    ]
                   
                );
             
            }
         
            BookPers::updateAll(
                [
                    "sort"=>$new,
                ],
                [
                    "id"=>$id,
                ]
            );

            return ['success' => 1];
            
        }
    }

    public function actionRelatives(){
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isPost) {
            $user = Yii::$app->user->identity;
     
            
        }
        return [];
    }

    
    function actionClearimg(){
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $value=$request->post();
            $element=$this->findModel($value['id']);
            $element->image="";
            $element->id_group=$element->findGroup();
            if($element->save()){ 
                return ['success' => 1];
            }
            return [];
            
        }
    }
   
}
