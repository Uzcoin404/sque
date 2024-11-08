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
    public $user_id = [];
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'list', 'admin'],
                'rules' => [

                    [
                        'actions' => ['index', 'list', 'admin'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],

        ];
    }

    public function actionIndex()
    {

        $user = Yii::$app->user->identity;

        $id_recipient = $this->RandomIdAdmin($user->id); //получаем случайного админа. Или того с кем общались в последний раз

        $model = new Chat();
        if ($model->load(Yii::$app->request->post())) {
            $model->sender_id = $user->id;
            $model->recipient_id = $id_recipient;
            $model->created_at = time();
            $model->status = 1;
            if (strlen($model->text) > 1) {
                if ($model->save()) {

                    return $this->redirect('/chat');
                }
            }
        }

        return $this->render(
            'index',
            [
                "chats" => Chat::find()->where(['sender_id' => $user->id])->orWhere(['recipient_id' => $user->id])->all(),
                "admin" => $id_recipient,
                "model" => $model,
            ]
        );
    }

    public function actionList()
    {

        $admin = Yii::$app->user->identity;

        $chat_list = Chat::find()->where(["recipient_id" => $admin])->all();

        $user_id = [];
        $user_id_no_read = [];
        foreach ($chat_list as $value) {
            if (!isset($user_id[$value->sender_id])) {
                if (Chat::GetNoRead($value->sender_id)) {
                    if (!isset($user_id_no_read[$value->sender_id])) {
                        $user_id_no_read[$value->sender_id] = Chat::LastData($value->sender_id);
                    }
                } else {
                    $user_id[$value->sender_id] = Chat::LastData($value->sender_id);
                }
            }
        }
        arsort($user_id);
        arsort($user_id_no_read);
        $result = $user_id_no_read + $user_id;

        // $result = array_unique($this->user_id);
        $pages = new Pagination(['totalCount' => count($result), 'pageSize' => 5, 'forcePageParam' => false, 'pageSizeParam' => false]);

        return $this->render(
            '_list',
            [
                "chats" => $result,
                "pages" => $pages,
            ]
        );
    }

    public function actionAdmin($slug)
    {

        $model = new Chat();

        $user = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post())) {
            $model->sender_id = $user->id;
            $model->recipient_id = $slug;
            $model->created_at = time();
            $model->status = 0;
            if (strlen($model->text) > 1) {
                if ($model->save()) {
                    header('Location: ' . $_SERVER['REQUEST_URI']);
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

    public function RandomIdAdmin($user_id = 0)
    {

        $admin = User::find()->where(["moderation" => 1])->all();
        foreach ($admin as $value) {
            array_push($this->admin_id, $value->id);
        }
        if ($user_id) {
            $user = Chat::find()->where(["sender_id" => $user_id])->orderBy("id DESC")->one();

            if (isset($user->recipient_id)) {
                return $user->recipient_id;
            }
        }
        $lenght = count($this->admin_id) - 1;

        if ($lenght < 0) {
            $lenght = 0;
        }

        $chat_admin = rand(0, $lenght);

        return $this->admin_id[$chat_admin];
    }

    public function SearchChat($user_id, $id_admin)
    {

        $user = Chat::find()->where(["sender_id" => $user_id])->all();

        if (!$user) {
            return 1;
        }

        $chat = Chat::find()->where(["sender_id" => $user_id, "recipient_id" => $id_admin])->all();

        if ($chat) {
            return 1;
        } else {
            return 0;
        }
    }
}
