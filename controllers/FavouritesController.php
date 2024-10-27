<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\Pagination;

use app\models\User;
use app\models\Favourites;
use app\models\Questions;
use app\models\ChangeEmail;


// AJAX
use yii\widgets\ActiveForm;


class FavouritesController extends Controller
{
    public $info = [];
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','delete'],
                'rules' => [

                    [ 
                        'actions' => ['index','create','delete'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],
                    [ 
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'], 
                    ],
                ],
            ],
            
        ];
    }

    public function actionIndex()
    {
        $user=Yii::$app->user->identity;

        $questions = Questions::find()->where(['in', 'status', [4,5,6]]);
        $queryLike = Favourites::find();
        $questions->leftJoin(['favourites'=>$queryLike], 'favourites.question_id = questions.id')->where(['user_id'=>$user->id])->orderBy(["cost"=>SORT_DESC]);
        $result = $questions;

        $pages = new Pagination(['totalCount' => $result->count(), 'pageSize' => 6, 'forcePageParam' => false, 'pageSizeParam' => false]);

        $result = $result->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

        return $this->render(
            'index',
            [
                "model"=>$result,
                "pages"=>$pages,
            ]
        );

    }

    public function actionCreate(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $favourites = new Favourites();

        $request = Yii::$app->request;

        $user=Yii::$app->user->identity;

        $this->info = [
            $request->get('question_id'),
        ];
        
        foreach($this->info as $post){
            foreach($post as $question_id){

                $favourites->question_id = $question_id;
                $favourites->user_id = $user->id;
                $favourites->created_at = strtotime('now');
                
                if($favourites->save(0)){
                    return \yii\helpers\Json::encode(
                        $favourites->id
                    );
                }
            }
        }
      

    }

    public function actionDelete(){

        $favourites = new Favourites();

        $request = Yii::$app->request;

        $user=Yii::$app->user->identity;

        $this->info = [
            $request->get('favourite_id'),
        ];
        
        foreach($this->info as $post){
                
                $favourit = Favourites::find()->where(['id'=>$post, 'user_id'=>$user->id])->one();
                
                $favourit->delete();
                
        }
    }  
}
