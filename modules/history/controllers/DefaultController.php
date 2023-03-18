<?php

namespace app\modules\history\controllers;
use Yii;
use app\modules\books\models\Books;
use app\modules\scenes\models\BookScenes;
use app\modules\text\models\BookText;
use yii\web\Controller;
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
                'only' => ['index','scenes','list'],
                'rules' => [
                    [
                        'actions' => ['index','scenes','list'],
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
           return $this->render('index',['model'=>new BookText()]);

    }

    private function GenerationGroups($book,$filter_element=false,$all_groups=false){
        $result=[];
        Foreach($filter_element as $element){
          //  foreach($element as $group){
                if($element->id_scenes){
                    if(isset($result[$element->id_scenes])){
                        array_push($result[$element->id_scenes]["elements"],$element);
                    }else{
                            $result[$element->id_scenes]=[
                                "group"=>$element->getGroup($element->id_scenes),
                                "elements"=>[$element]
                            ];
                        
                    }
                }
                
          //  }
        }
      
        return $result;
     }

    public function actionList(){
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            $all_groups=false;
           \Yii::$app->response->format = Response::FORMAT_JSON;
            $value=$request->post();
            
            $user = Yii::$app->user->identity;
            $active_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one();
            if(!isset($active_book->id))
                return [];
            $scenes= BookScenes::find()->where(['id_book'=>$active_book->id])->all();
            $ids=[];
            foreach( $scenes as  $scene){
                $ids[$scene->id]=$scene->id;
            }
         
            $result= BookText::find()->where(
                ['in','id_scenes',$ids]
            )->orderBy(['date'=>SORT_DESC,'id_scenes'=>SORT_ASC]);
           
            if(isset($value['filter_items_groups'])){
                $all_groups=[];
                $filter_group=["OR"];
                foreach($value['filter_items_groups'] as $group){
                    $all_groups[]=$group;
                    array_push(
                        $filter_group,
                        [
                            'like',
                            'id_scenes',
                            $group,
                        ]
                    );
                }
                $result->andFilterWhere($filter_group);
                //$result->where(['in','id_scenes',$value['filter_items_groups']]);
            }
            if(isset($value['filter_items_name']) && $value['filter_items_name']>0){
                $result->andWhere(
                
                    ['>=','date',strtotime($value['filter_items_name']." 00:00:00")]
                    
                );
                $result->andWhere(
                    ['<=','date',strtotime($value['filter_items_name']."23:59:59")]
                    
                );
            }
            
            
            $result=$result->all();
            $groups=$this->GenerationGroups($active_book->id,$result,$all_groups);
            return [
                'success' => $this->renderAjax('list', [
                    'groups' => $groups,
                ]),
            ];
        
        }
    }

    public function actionScenes(){
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
           \Yii::$app->response->format = Response::FORMAT_JSON;
            $value=$request->post();
            $user = Yii::$app->user->identity;
            $book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one();
            if(!isset($book->id))
                return [];
            $result= BookScenes::find()->where(['id_book'=>$book->id])->all();
            return [
                'success' => $this->renderAjax('scenes/list', [
                    'models' => $result,
                    "user"=>$user,
                ]),
            ];
        
        }
    }
}
