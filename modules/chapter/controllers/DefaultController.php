<?php

namespace app\modules\chapter\controllers;

use Yii;
use app\modules\books\models\Books;
use app\modules\chapter\models\BookChapter;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
//Модули прав доступа
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


// AJAX
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * DefaultController implements the CRUD actions for BookChapter model.
 */
class DefaultController extends Controller
{
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','create','update','validate'],
                'rules' => [
                    [
                        'actions' => ['index','view','create','update','validate'],
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
    /**
     * Lists all BookChapter models.
     * @return mixed
     */
    public function actionIndex($book_id)
    {
      
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        /****** ПРОВЕРКА КНИГИ И ПОЛЬЗОВАТЕЛЯ *******/
        $user = Yii::$app->user->identity;
        $book=Books::find()->where(
            [
                "id_user"=>$user->id,
                "id"=>$book_id
            ]
        )->one();
        if(!isset($book->id))
        return [];
        /****** ПРОВЕРКА КНИГИ И ПОЛЬЗОВАТЕЛЯ *******/
            $result=BookChapter::find()->where(["id_book"=>$book_id])->all();
            return ['success' => $result];
        }
        return [];
    }

    /**
     * Displays a single BookChapter model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BookChapter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($book_id)
    {
        /****** ПРОВЕРКА КНИГИ И ПОЛЬЗОВАТЕЛЯ *******/
        $user = Yii::$app->user->identity;
        $book=Books::find()->where(
             [
                 "id_user"=>$user->id,
                 "id"=>$book_id
             ]
         )->one();
        if(!isset($book->id))
        return [];
        /****** ПРОВЕРКА КНИГИ И ПОЛЬЗОВАТЕЛЯ *******/
        
        $model = new BookChapter();
        $this->layout="/none";
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $model->id_book=$book->id;
            return ['success' => $model->save()];
        }
       
        return [];
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

  
    public function actionDelete($id)
    {
       // $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = BookChapter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionValidate()
    {
        $model = new BookChapter();
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }
}
