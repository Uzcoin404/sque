<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Notes;
use app\models\NoteGroups;
use app\modules\books\models\Books;
// AJAX
use yii\widgets\ActiveForm;
class NoteController extends Controller
{
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','form','create','update','validate','ajxindex','ajxsort','delete','copy','sceneform','scenecreate','favorite'],
                'rules' => [
                    [
                        'actions' => ['index','form','create','update','validate','ajxindex','ajxsort','delete','copy','sceneform','scenecreate','favorite'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            
        ];
    }
    public function actionValidate()
    {
        $model = new Notes();
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    private function GenerationGroups($user,$filter_element=false,$all_groups=false,$book_id=false){

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
            $groups=NoteGroups::find()->where(['id_user'=>$user,'id'=>$all_groups])->orderBy(['name'=>SORT_ASC])->all(); 
           
        }else{
            $groups=NoteGroups::find()->where(['id_user'=>$user,"id_book"=>$book_id])->orderBy(['name'=>SORT_ASC])->all();
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
   

    //Главный экран
    public function actionIndex()
    {
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $this->layout="/none";
            $user = Yii::$app->user->identity;
            $value=$request->post();
          
          
            $book_id=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
            $notes=Notes::find()->where(["id_book"=>$book_id,'status'=>1]);
            if(isset($value['id_target']) && $value['id_target']>0){
                $notes->andWhere(
                    [
                        "id_target"=>$value['id_target']
                    ]
                );
            }
            
            $type=0;
            if(isset($value['type']) && $value['type']>0){
                $type=$value['type'];
                $notes->andWhere(
                    [
                        "type"=>$type
                    ]
                );
            }
    
            $notes=$notes->orderBy(["favorite"=>SORT_ASC,"type"=>SORT_ASC,"id_group"=>SORT_ASC,"sort"=>SORT_ASC])->all();
            if(isset($value['scenes_list']) && $value['scenes_list']>0){
                return [
                
                    'success' =>  $this->renderAjax('notes_scenes_list', [
                                    'models' => $notes,
                                    "user"=>$user,
                                    "book_id"=>$book_id,
                                    "type"=>$type,
                                    "scene"=>$value['scenes_list']
                                ])
                ];
            }
            return [
                
                'success' =>  $this->renderAjax('notes', [
                                'models' => $notes,
                                "user"=>$user,
                                "book_id"=>$book_id,
                                "type"=>$type,
                            ])
            ];
        }
        return $this->render(
            'index'
        );
        
    }

    public function actionCopy(){
        
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $value=$request->post();
            $Books=$this->findModel($value['id']);
            $data = $Books->attributes;
            $new_books= new Notes();
            $new_books->setAttributes($data);
            $new_books->id_group=$Books->group;
            $new_books->id_user=$Books->id_user;
            if($new_books->save()){ 
                // return ['success' => 1];
                 //18-10-2021
                 return [
                     'success' => $new_books->id, 
                     "element"=>$new_books->id, 
                     "html"=>  $this->renderAjax('_view', [
                         'element' => $new_books,
                         'dataIndex'=>$new_books->sort
                     ])
                 ]; 
                 //18-10-2021
             }
             return ['success' => 0];
            return [$new_books->getErrors()];
            
        }
    }

    public function actionAjxindex(){
        $request = \Yii::$app->getRequest();
        
        if ($request->isPost) {
            $all_groups=false;
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $this->layout="/none";
            $user = Yii::$app->user->identity;
            $value=$request->post();
          
            $book_id=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
            $notes=Notes::find()->where(["id_book"=>$book_id,'status'=>1,"id_user"=>$user->id]);
            if(isset($value['filter_items_name'])){
                $notes->andWhere(['like', 'name', $value['filter_items_name']]);
            }
            if(isset($value['filter_items_objects']) && $value['filter_items_objects']>0){
                $filter_group=["OR"];
                foreach($value['filter_items_objects'] as $group){
                    array_push(
                        $filter_group,
                        [
                            'like',
                            'type',
                            $group,
                        ]
                    );
                }
                $notes->andFilterWhere($filter_group);
               // $notes->andWhere(['in','type', $value['filter_items_objects']]);
            }
            if(isset($value['filter_items_groups']) && $value['filter_items_groups']>0){
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
                $notes->andFilterWhere($filter_group);
                //$notes->andWhere(['like','id_group', $value['filter_items_groups']]);
            }
            $notes=$notes->orderBy(["type"=>SORT_ASC,"id_group"=>SORT_ASC,"sort"=>SORT_ASC])->all();
            $groups=$this->GenerationGroups($user->id,$notes,$all_groups,$book_id);
            return [
                'success' =>  $this->renderAjax('render', [
                                'groups' => $groups,
                                "user"=>$user,
                                "book_id"=>$book_id,
                            ])
            ];
        }
    }

    public function actionAjxsort(){
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $user = Yii::$app->user->identity;
            $value=$request->post();
            $id=(int)$value['id'];
            $old=(int)$value['old']+1;
            $new=(int)$value['new']+1; 
            if($old > $new){ 
                Notes::updateAll(
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
                Notes::updateAll(
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
         
            Notes::updateAll(
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


    public function actionForm(){
  
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isPost) {
            $this->layout="/none";
            $user = Yii::$app->user->identity;
            $value=$request->post();
            $model = new Notes();
           
            if(isset($value['id']) && $value['id']>0){
                $model = $this->findModel($value['id']);
                return [
                    'success' =>  $this->renderAjax('_form_update_note', [
                                    'model' => $model,
                                    "user"=>$user,
                                ])
                ];
            }
            $model->type=1;
            if(isset($value['type'])){
                $model->type=$value['type'];
            }
            $model->id_target=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
            if(isset($value['id_target'])){
                $model->id_target=$value['id_target'];
            }
            if(isset($value['group_id'])){
                $model->group=$value['group_id'];
                $model->id_group=$value['group_id'];
            }
            
                return [
                    'success' =>  $this->renderAjax('_form_create_note', [
                                    'model' => $model,
                                    "user"=>$user,
                                ])
                ];
            
           
    
        }
        return ['success' => 0];
    }

    public function actionCreate()
    {
        $model = new Notes();
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isPost && $model->load($request->post())) {
                $user = Yii::$app->user->identity;
                $model->id_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
                $model->sort=$model->getMaxSort();
                $model->id_group=$model->findGroup();
                $model->id_user=$user->id;
                if($model->save()){
                    return ['success' =>$model->id];
                }
                return ['success' => 0];
            }
        
        
        return ['success' => 0];
    
    }
    public function actionUpdate($id)
    {
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model =$this->findModel($id);
            if ($request->isPost && $model->load($request->post())) {
                $model->id_group=$model->findGroup();
                 //if($model->save()){ 
                //    return ['success' => $model->id];
               // }
                //18-10-2021
                if($model->save()){
                    return [
                        'success' => $model->id, 
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

    public function actionDelete($id)
    {
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        Notes::updateAll(
            [
                "status"=>0,
            ],
            [
                "id"=>$id,
            ]
        );
        return ['success' =>1];
    
    }
    protected function findModel($id)
    {
        if (($model = Notes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSceneform(){
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isPost) {
            $this->layout="/none";
            $user = Yii::$app->user->identity;
            $value=$request->post();
            $model = new Notes();
            return [
                'success' =>  $this->renderAjax('scenes/_form_create', [
                                'model' => $model,
                                "user"=>$user,
                                "scenes"=>$value['id_scene'],
                            ])
            ];
           
        }
        return ['success' => 0];
    }

    public function actionScenecreate($id_scene)
    {
   
        $user = Yii::$app->user->identity;
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $value=$request->post();
 
        if(isset($value['Notes']['id_scenes'])){
            $user = Yii::$app->user->identity;
            $active_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one();
            foreach($value['Notes']['id_scenes'] as $id){
                $model=$this->findModel($id);
                $model->id_target=$id_scene;
                $model->type=2;
                $model->id_book=$active_book->id;
                $model->id_group=$model->group;
                $model->id_user=$user->id;
                $model->save();
            }
        }
        return ['success' => 1];
    
    }

    public function actionFavorite(){
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isPost) {
            $value=$request->post();
            Notes::updateAll(
                [
                    "favorite"=>(int)$value['favorite'],
                ],
                [
                    "id"=>$value['id'],
                ]
            );
            return ['success' => (int)$value['favorite']];
        }
        return ['success' => 0];
    }
}
