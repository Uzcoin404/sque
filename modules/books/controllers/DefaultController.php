<?php

namespace app\modules\books\controllers;

use Yii;
use app\modules\books\models\Books;
use app\modules\books\models\BookGroups;
use app\models\Notes;
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
                 'only' => ['index','filter','create','update','master','setmain','form','validate','delete','copy','active','sort','getactivestory','createfirstpage','clearimg','updatestat'],
                 'rules' => [
                     [
                         'actions' => ['index','filter','create','update','master','setmain','form','validate','delete','copy','active','sort','getactivestory','createfirstpage','clearimg','updatestat'],
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
         $model = new Books();
         $request = \Yii::$app->getRequest();
         if ($request->isPost && $model->load($request->post())) {
             \Yii::$app->response->format = Response::FORMAT_JSON;
             return ActiveForm::validate($model);
         }
     }

     private function GenerationGroups($user,$filter_element=false,$all_groups=false){
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
            $groups=BookGroups::find()->where(['id_user'=>$user,'id'=>$all_groups])->orderBy(['name'=>SORT_ASC])->all(); 
           
        }else{
            $groups=BookGroups::find()->where(['id_user'=>$user])->orderBy(['name'=>SORT_ASC])->all();
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

     public function actionFilter()
     {
        
        $request = \Yii::$app->getRequest();
      
        if ($request->isPost) {
            $all_groups=false;
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $this->layout="//none";
            $value=$request->post();
            $user = Yii::$app->user->identity;
            $books=Books::find()->where(["id_user"=>$user->id,'status'=>1]);
            if(isset($value['book_filter_name'])){
                $books->andWhere(['like', 'name', $value['book_filter_name']]);
            }
            if(isset($value['filter_book_groups'])){
                $all_groups=[];
                $filter_group=["OR"];
                foreach($value['filter_book_groups'] as $group){
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
                $books->andFilterWhere($filter_group);
            }

            $books=$books->orderBy(
                    ['id_group'=>SORT_ASC, 'sort'=>SORT_ASC]
            )->all();
            $groups=$this->GenerationGroups($user->id,$books,$all_groups);
            return [
                'success' => $this->renderAjax(
                            'render',
                            [
                                "user"=>$user,
                                "groups"=>$groups,
                            ]
                            )
            ];
        }
       
        return ['success' => 0];
     }

     public function actionCreatefirstpage(){
        echo 1; exit;
        $model = new Books;
        
        if ($model->load(Yii::$app->request->post())) {
 
            $model->main=1;
            $user = Yii::$app->user->identity;
            $model->id_user=$user->id;
            $model->date_chenge=strtotime('now');
            $model->status=1;
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->image="";
            if(isset($model->imageFile)){
                $model->image=$model->upload();
                $model->imageFile="";
            }
            $model->date_end=strtotime($model->date_end." 23:59:59");
            $model->date_create=strtotime( $model->date_create);
            $model->sort=1;
            //Проверяем есть ли группы по умолчания, если нет, то создаем
            $count_default_book_group=BookGroups::find()->where(
                [
                    "isDefault"=>1,
                    "id_user"=>$user->id,
                ]
            )->count();
            if($count_default_book_group<=0){
                $model->group=[$model->group];
            }else{
                $model->group=[];//[$model->group];
            }
            $model->id_group=$model->findGroup();
            if($model->save()){

                

                    //Создать группы по умолчанию для
                    //Заметок
                    //Сцен
                    $item=new \app\modules\items\models\BookItemsGroup;
                    $item->name="Без группы";
                    $item->id_user=$user->id;
                    $item->id_book=$model->id;
                    $item->isDefault=1;
                    $item->color="#f2f2f2";
                    $item->save();

                    $location=new \app\modules\locations\models\BookLocationsGroup;
                    $location->name="Без группы";
                    $location->id_user=$user->id;
                    $location->id_book=$model->id;
                    $location->isDefault=1;
                    $location->color="#f2f2f2";
                    $location->save();


                    $pers=new \app\modules\pers\models\BookPersGroup;
                    $pers->name="Без группы";
                    $pers->id_user=$user->id;
                    $pers->id_book=$model->id;
                    $pers->isDefault=1;
                    $pers->color="#f2f2f2";
                    $pers->save();

                    $scenes=new \app\modules\scenes\models\BookScenesGroup;
                    $scenes->name="Без группы";
                    $scenes->id_user=$user->id;
                    $scenes->id_book=$model->id;
                    $scenes->isDefault=1;
                    $scenes->color="#f2f2f2";
                    $scenes->save();

                    $note=new \app\models\NoteGroups;
                    $note->name="Без группы";
                    $note->id_user=$user->id;
                    $note->id_book=$model->id;
                    $note->isDefault=1;
                    $note->color="#f2f2f2";
                    $note->save();
                
                
            }
            $this->redirect("/main");
        } 
        $this->redirect("/main");
        
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

     public function actionForm(){
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isPost) {
            $this->layout="/none";
            $user = Yii::$app->user->identity;
            $value=$request->post();
            $model = new Books();
            
            if(isset($value['book_id']) && $value['book_id']>0){
                $model = $this->findModel($value['book_id']);
                return [
                    'success' =>  $this->renderAjax('_form_update', [
                                    'model' => $model,
                                    "user"=>$user,
                                ])
                ];
            }
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
        $model = new Books();
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isPost && $model->load($request->post())) {
                $user = Yii::$app->user->identity;
                $model->id_user=$user->id;
                $model->date_chenge=strtotime('now');
                //$model->date_create=strtotime('now');
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $model->image="";
                if(isset($model->imageFile)){
                    $model->image=$model->upload();
                    $model->imageFile="";
                }
                $model->date_end=strtotime($model->date_end." 23:59:59");
                $model->date_create=strtotime( $model->date_create);
                    $model->sort=$model->getMaxSort();
                    $model->id_group=$model->findGroup();
                    $model->status=1;
                    if($model->main){
                        Books::updateAll(
                            [
                                "main"=>0,
                            ],
                            [
                                "main"=>1,
                                "id_user"=>$user->id,
                            ]
                        );
                    }
                    //$model->save();
                    //18-10-2021
                    if($model->save()){
                        $item=new \app\modules\items\models\BookItemsGroup;
                        $item->name="Без группы";
                        $item->id_user=$user->id;
                        $item->id_book=$model->id;
                        $item->isDefault=1;
                        $item->color="#f2f2f2";
                        $item->save();
    
                        $location=new \app\modules\locations\models\BookLocationsGroup;
                        $location->name="Без группы";
                        $location->id_user=$user->id;
                        $location->id_book=$model->id;
                        $location->isDefault=1;
                        $location->color="#f2f2f2";
                        $location->save();
    
    
                        $pers=new \app\modules\pers\models\BookPersGroup;
                        $pers->name="Без группы";
                        $pers->id_user=$user->id;
                        $pers->id_book=$model->id;
                        $pers->isDefault=1;
                        $pers->color="#f2f2f2";
                        $pers->save();
    
                        $scenes=new \app\modules\scenes\models\BookScenesGroup;
                        $scenes->name="Без группы";
                        $scenes->id_user=$user->id;
                        $scenes->id_book=$model->id;
                        $scenes->isDefault=1;
                        $scenes->color="#f2f2f2";
                        $scenes->save();
    
                        $note=new \app\models\NoteGroups;
                        $note->name="Без группы";
                        $note->id_user=$user->id;
                        $note->id_book=$model->id;
                        $note->isDefault=1;
                        $note->color="#f2f2f2";
                        $note->save();
                        
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

    public function actionUpdatestat($id){
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model =$this->findModel($id);
            if ($request->isPost && $model->load($request->post())) {
               
                $user = Yii::$app->user->identity;
                $model->date_chenge=strtotime('now');
                $model->date_end=strtotime($model->date_end." 23:59:59");
                $model->date_create=strtotime( $model->date_create);                
                $model->id_group=$model->group;      
   
                //28-11-2021
                if($model->save()){
                    return [
                        'success' => 1, 
                    ]; 
                }
                return ['success' => 0  ]; 
                //28-11-2021
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
                $model->date_chenge=strtotime('now');
                $model->date_end=strtotime($model->date_end." 23:59:59");
                $model->date_create=strtotime( $model->date_create);
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
                //return ['success' => $model  ]; 
                if($model->main){
                    //Если книга отмечается как главная у всех остальных убираем эту отметку
                    Books::updateAll(
                        [
                            "main"=>0,
                        ],
                        [
                            'AND',[
                                "main"=>1,
                                "id_user"=>$user->id,
                            ],
                            ['<>','id',$model->id]
                            
                        ]
                    );
    
                }
   
                //18-10-2021
                if($model->save()){
                    if(!$model->main){
                        //Если книга не активна требуется проверить, если ли у этого пользователя активные книги
                        $count_main_book=Books::find()->where(
                            [
                                "main"=>1,
                                "id_user"=>$user->id,
                                'status'=>1,//Статус тоже надо проверять
                            ]
                        )->count();
                        if($count_main_book<=0){
                        //Внимание книг активных нет
                            $book_new_main=Books::find()->where(
                                [
                                    "id_user"=>$user->id,
                                    'status'=>1,//Статус тоже надо проверять
                                ]
                            )->one();
                            if(isset($book_new_main->id)){
                                $book_new_main->main=1;
                                $book_new_main->id_group=$book_new_main->group;
                                $book_new_main->save();
                            }
                            $reload_page=1;
    
                        }
                    }
                    return [
                        'success' => 1, 
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


    protected function findModel($id)
    {
        if (($model = Books::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSetmain($books_id){
        return [];
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $user = Yii::$app->user->identity;
            Books::updateAll(
                [
                    'main' => 0
                ],
                [
                    'id_user'=>$user->id
                ]
            );
            $Books=$Books->findModel();
            $Books->main=1;
            if($Books->save()){
                Yii::$app->session->set('book_id', $Books->id);
                Yii::$app->session->set('book_name', $Books->name);
                return ['success' => 1,'id'=>$Books->id,'name'=>$Books->name];
            }
            return [];
            
        }
    }

    public function actionDelete(){
        
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
         
            $value=$request->post();
            $Books=$this->findModel($value['id']);
            $Books->status=0;
            $user = Yii::$app->user->identity;
            $update_main=false;
            if($Books->main==1){
                $update_main=true;
               
            }
            
            $Books->main=0;
            $reload=false;
            $Books->id_group=$Books->group;
           // $Books->id_group=$Books->findGroup();
           $mainbook=0;
            if($Books->save()){ 
                
                Notes::updateAll(
                    [
                        "id_target"=>0,
                        "id_book"=>0
                    ],
                    "type=:type AND id_target =:id_target and id_book = :id_book",
                    [
                        ":type"=>1,
                        ":id_book"=>$Books->id,
                        ":id_target"=>$Books->id,
                    ]
                   
                );
                if($update_main){
              
                    $first_book=Books::find()->where(
                        [
                            "id_user"=>$user->id,
                            'status'=>1,
                        ]
                    )->andWhere(['<>','id', $Books->id])->one();
                    if(isset($first_book->id)){
                        $mainbook=$first_book->id;
                        $first_book->main=1;
                        $first_book->id_group=$first_book->group;
                        $first_book->save();
                        
                    }else{
                        $reload=true;
                    }
                }
                return ['success' => 1, "reload"=>$reload, "mainbook"=>$mainbook];
            }
            return [];
            
        }
    }
    public function actionCopy(){
        
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $user = Yii::$app->user->identity;
            $value=$request->post();
            $Books=$this->findModel($value['id']);
            $data = $Books->attributes;
            $new_books= new Books();
            $new_books->setAttributes($data);
            $new_books->main=0;
            $new_books->id_group=$Books->group;
            if($new_books->save()){ 
                 //Создать группы по умолчанию для
                //Заметок
                //Сцен
                $item=new \app\modules\items\models\BookItemsGroup;
                $item->name="Без группы";
                $item->id_user=$user->id;
                $item->id_book=$new_books->id;
                $item->isDefault=1;
                $item->color="#f2f2f2";
                $item->save();

                $location=new \app\modules\locations\models\BookLocationsGroup;
                $location->name="Без группы";
                $location->id_user=$user->id;
                $location->id_book=$new_books->id;
                $location->isDefault=1;
                $location->color="#f2f2f2";
                $location->save();


                $pers=new \app\modules\pers\models\BookPersGroup;
                $pers->name="Без группы";
                $pers->id_user=$user->id;
                $pers->id_book=$new_books->id;
                $pers->isDefault=1;
                $pers->color="#f2f2f2";
                $pers->save();

                $scenes=new \app\modules\scenes\models\BookScenesGroup;
                $scenes->name="Без группы";
                $scenes->id_user=$user->id;
                $scenes->id_book=$new_books->id;
                $scenes->isDefault=1;
                $scenes->color="#f2f2f2";
                $scenes->save();

                $note=new \app\models\NoteGroups;
                $note->name="Без группы";
                $note->id_user=$user->id;
                $note->id_book=$new_books->id;
                $note->isDefault=1;
                $note->color="#f2f2f2";
                $note->save();
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
            return [$new_books->getErrors()];
            
        }
    }
    
    public function actionActive($books_id){
        return [];
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $Books=$this->findModel($books_id);
            $Books->status=1;
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
            $id=$value['id'];
            $old=$value['old'];
            $new=$value['new'];
            if($old > $new){ 
               // return;
                Books::updateAll(
                    [
                        "sort"=>new \yii\db\Expression('`sort` + 1'),
                    ],
                    "id_user=:id_user AND sort >=:NEW and sort < :OLD",
                    [
                        ":id_user"=>$user->id,
                        ":NEW"=>$new,
                        ":OLD"=>$old
                    ]
                   
                );
            
            }
            if($old < $new){ 
                Books::updateAll(
                    [
                        "sort"=>new \yii\db\Expression('`sort` - 1'),
                    ],
                    "id_user=:id_user AND sort <=:NEW and sort >=:OLD",
                    [
                        ":id_user"=>$user->id,
                        ":NEW"=>$new,
                        ":OLD"=>$old
                    ]
                   
                );
             
            }
         
            Books::updateAll(
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

    public function actionGetactivestory(){
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $active_book=false;
        $user = Yii::$app->user->identity;
        $active_book=Books::find()->where(
            [
                "id_user"=>$user->id,
                "main"=>1,
                'status'=>1,
            ]
        )->one();
        if(!$active_book) return [];
            if ($request->isPost && $active_book->load($request->post())) {
               
                $user = Yii::$app->user->identity;
                $active_book->date_chenge=strtotime('now');    
                $active_book->id_group=$active_book->group;  
                return ['success' =>  $active_book->save()]; 
            }else{
                return [
                    'success' =>  $this->renderAjax('_form_update_story', [
                                    'model' => $active_book,
                                    "user"=>$user,
                    ]),
                    "id"=>$active_book->id,
                ];
            }
        
        
        return ['success' => 0];
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
