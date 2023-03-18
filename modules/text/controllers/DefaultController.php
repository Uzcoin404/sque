<?php

namespace app\modules\text\controllers;
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
                'only' => ['index','view','create','update','repository','save'],
                'rules' => [
                    [
                        'actions' => ['index','view','create','update','repository','save'],
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
    public static function countWords($string)
    {
        return count(preg_split('/\s+/u', $string, null, PREG_SPLIT_NO_EMPTY));
    }

    public function actionSave($id_scenes,$id_book){
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isPost){
            if(isset($request->post()['BookText']['text'])){
                $text=$request->post()['BookText']['text'];
                $hash=MD5($id_book."".$id_scenes."".$text);
                $bookText=BookText::find()->where(['id_scenes'=>$id_scenes])->orderBy(["date"=>SORT_DESC])->one();
                if(isset($bookText->id) && $bookText->hash==$hash){
                    return ['success' => 1,'count'=>0];
                }
             
                $bookText=new BookText();
                $bookText->text=$text;
                $bookText->hash=$hash;
                $bookText->id_scenes=$id_scenes;
                $bookText->date=strtotime('now');
                $text = trim(strip_tags(html_entity_decode($text,ENT_QUOTES)));
                $bookText->length=$this->countWords($text);
                return ['success' => $bookText->save(false),'count'=>$bookText->length];
            }
        }
        return ['success' => 2];
    }
    public function actionIndex($id_scenes,$id_book)
    {
        $user = Yii::$app->user->identity;
      
            $Scenes=BookScenes::find()->where(["id"=>$id_scenes])->one();
            $bookText= BookText::find()->where(["id_scenes"=>$id_scenes])->orderBy("date DESC")->one();
            if(!isset($bookText->id))
            $bookText=new BookText();
          
           return $this->render('index',['user'=>$user,'model'=>$bookText,'Scenes'=>$Scenes]);
        
       
    }

    public function actionRepository($id_rep){
        $user = Yii::$app->user->identity;
        $bookText= BookText::find()->where(["id"=>$id_rep])->orderBy("date DESC")->one();
        $Scenes=BookScenes::find()->where(["id"=>$bookText->id_scenes])->one();
        $bookText->isNewRecord=1;
        $bookTextNew=new BookText();
        $bookTextNew->id_scenes=$bookText->id_scenes;
        $bookTextNew->text=$bookText->text;
        return $this->render('repository',['user'=>$user,'model'=>$bookTextNew,'Scenes'=>$Scenes]);
    }
}
