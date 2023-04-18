<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

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

        $favourites = Favourites::find()->where(['id_user'=>$user->id])->all();
        return $this->render(
            'index',
            [
                "model"=>$favourites,
            ]
        );

    }

    public function actionCreate(){

        $favourites = new Favourites();

        $request = Yii::$app->request;

        $user=Yii::$app->user->identity;

        $this->info = [
            $request->get('question_id'),
        ];
        
        foreach($this->info as $post){
            foreach($post as $question_id){

                $favourites->id_question = $question_id;
                $favourites->id_user = $user->id;
                $favourites->data = strtotime('now');
                
                $favourites->save(0);
                
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
                
                $favourit = Favourites::find()->where(['id'=>$post, 'id_user'=>$user->id])->one();
                
                $favourit->delete();
                
        }
    }  
}
