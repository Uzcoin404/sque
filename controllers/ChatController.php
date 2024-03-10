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
use app\models\Chat;
use app\models\ChangeEmail;


// AJAX
use yii\widgets\ActiveForm;


class ChatController extends Controller
{
    public $info = [];
    public $admin_id = [];
    public $id_user = [];
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','list','admin'],
                'rules' => [

                    [ 
                        'actions' => ['index','list','admin'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],

                ],
            ],
            
        ];
    }

    public function actionIndex()
    {

        $user=Yii::$app->user->identity;

        $id_recipient = $this->RandomIdAdmin($user->id); //получаем случайного админа. Или того с кем общались в последний раз

        $model = new Chat();
            if ($model->load(Yii::$app->request->post())) {
                $model->sender_id=$user->id;
                $model->recipient_id=$id_recipient;
                $model->data=strtotime('now');
                $model->status=1;
                if(strlen($model->text)>1){
                    if($model->save()){
                
                        return $this->redirect('/chat');
                    }
                }
                
            }
       
            return $this->render(
                'index',
                [
                    "chats" => Chat::find()->where(['sender_id'=>$user->id])->orWhere(['recipient_id'=>$user->id])->all(),
                    "admin" => $id_recipient,
                    "model" => $model,
                ]
            );
        
    
       



    }

    public function actionList(){

        $admin = Yii::$app->user->identity;

        $chat_list = Chat::find()->where(["recipient_id"=>$admin])->all();

        $id_user=[];
        $id_user_no_read=[];
        foreach($chat_list as $value){
            if(!isset($id_user[$value->sender_id])){
                if(Chat::GetNoRead($value->sender_id)){
                    if(!isset($id_user_no_read[$value->sender_id])){
                        $id_user_no_read[$value->sender_id]=Chat::LastData($value->sender_id);
                    }
                }else{
                    $id_user[$value->sender_id]=Chat::LastData($value->sender_id);
                }
                
            }
           
        }
        arsort($id_user);
        arsort($id_user_no_read);
        $result = $id_user_no_read+$id_user;
     
       // $result = array_unique($this->id_user);
        $pages = new Pagination(['totalCount' => count($result), 'pageSize' => 5, 'forcePageParam' => false, 'pageSizeParam' => false]);

        return $this->render(
            '_list',
            [
                "chats" => $result,
                "pages"=>$pages,
            ]
        );

    }

    public function actionAdmin($slug){

        $model = new Chat();

        $user=Yii::$app->user->identity;
        
        if ($model->load(Yii::$app->request->post())) {
            $model->sender_id=$user->id;
            $model->recipient_id=$slug;
            $model->data=strtotime('now');
            $model->status=0;
            if(strlen($model->text)>1){
                if($model->save()){
                    header('Location: '.$_SERVER['REQUEST_URI']);
                }
            }
        }

        return $this->render(
            '_send_admin',
            [
                "chats" => Chat::find()->all(),
                "model" => $model,
                "id" => $slug,
            ]
        );
    }

    public function RandomIdAdmin($id_user=0){

        $admin = User::find()->where(["moderation"=>1])->all();
        foreach($admin as $value){
            array_push($this->admin_id, $value->id);
        }
        if($id_user){
            $user = Chat::find()->where(["sender_id"=>$id_user])->orderBy("id DESC")->one();
        
            if(isset($user->recipient_id)){
                return $user->recipient_id;
            }
        }
        $lenght = count($this->admin_id) - 1;

        if($lenght < 0){
            $lenght = 0;
        }

        $chat_admin = rand(0, $lenght);

        return $this->admin_id[$chat_admin];

    }

    public function SearchChat($id_user, $id_admin){

        $user = Chat::find()->where(["sender_id"=>$id_user])->all();

        if(!$user){
            return 1;
        }

        $chat = Chat::find()->where(["sender_id"=>$id_user,"recipient_id"=>$id_admin])->all();

        if($chat){
            return 1;
        } else {
            return 0;
        }

    }

  
}
