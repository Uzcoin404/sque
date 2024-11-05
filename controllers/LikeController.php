<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\User;
use app\models\Like;
use app\models\ViewsAnswers;
use app\models\Answers;
use app\models\LikeAnswers;
use app\models\DislikeAnswer;
use app\models\ChangeEmail;
use app\models\Questions;
use yii\db\Expression;


// AJAX
use yii\widgets\ActiveForm;


class LikeController extends Controller
{
    public $user_id = [];
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'user'],
                'rules' => [

                    [
                        'actions' => ['index', 'block', 'filterlike'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    [
                        'actions' => ['block', 'filterlike'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],

                ],
            ],

        ];
    }

    public $info = [];
    public $user_info = [];
    public $image = [];

    public function actionIndex()
    {
        $like = new Like();
        $request = Yii::$app->request;

        $user = Yii::$app->user->identity;

        $like->question_id = 12;
        $like->user_id = $user->id;
        $like->created_at = strtotime('now');

        $this->LikeAnswers();

        $like->save();
    }

    public function LikeAnswers()
    {
        $request = Yii::$app->request;

        $user = Yii::$app->user->identity;

        $this->info = [
            $request->get('id_answer_like'),
        ];
        if (!$user) {
            return;
        }

        foreach ($this->info as $post) {
            if ($post) {
                foreach ($post as $like) {
                    $answer_id = $like['answer'];
                    $answer_views = ViewsAnswers::find()->where(["answer_id" => $answer_id, "user_id" => $user->id])->one();

                    $answer_like = LikeAnswers::find()->andWhere(["answer_id" => $answer_id, "user_id" => $user->id])->one();
                    // $answer_dis = DislikeAnswer::find()->andWhere(["answer_id" => $answer_id, "user_id" => $user->id])->one();

                    if ($answer_like) {

                        if ($answer_like->status == 1 && $answer_views->button_click == 0) {

                            ViewsAnswers::find()->where(['answer_id' => $answer_id])->one()->delete();
                        }
                        $answer_like->delete();
                        Answers::updateAll(['likes' => new Expression('likes - 1')], ['id' => $answer_id]);

                    } else {
                        $answer = Answers::find()->where(["id" => $answer_id])->one();
                        $question = Questions::find()->where(['id' => $like['question'][0]])->one();

                        // if ($answer_dis) {
                        //     $answer_dis->delete();
                        // }

                        if ($question->status == 5) {
                            if ($answer->user_id != $user->id && $user->moderation == 0) {
                                $likes = new LikeAnswers();
                                $likes->answer_id = $answer_id;
                                $likes->question_id = $like['question'][0];
                                $likes->user_id = $user->id;
                                $likes->status = 1;
                                $likes->created_at = time();
                                $likes->save();
                                $answer->likes = $answer->likes + 1;
                                $answer->update();
                                if (!$answer_views) {
                                    $newView = new ViewsAnswers();
                                    $newView->answer_id = $answer->id;
                                    $newView->user_id = $user->id;
                                    $newView->user_type = 1;
                                    $newView->created_at = time();
                                    $newView->save();
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function actionBlock()
    {

        $request = Yii::$app->request;

        $this->info = [
            $request->get('id_block'),
        ];

        $answer = LikeAnswers::find()->andWhere(['answer_id' => $this->info[0]])->all();

        foreach ($answer as $value) {
            array_push($this->user_id, $value->user_id);
        }

        foreach ($this->user_id as $user) {
            $user_info  = User::find()->where(['id' => $user])->one();
            array_push($this->user_info, array("user" => $user_info->username, "img" => $user_info->image));
        }

        \Yii::$app->response->format = 'json';

        return $this->user_info;
    }

    public function actionFilterlike()
    {
        // ->where(['question_id'=>$_GET['question_id']])
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $status = 0;
        $result = "";
        $data = Yii::$app->request->post();
        $sort = $data['sorts'];
        $id = $data['id'];
        $answer = Answers::find()->where(['in', 'question_id', $id]);
        // $answerLike = LikeAnswers::find()
        //     ->select('answer_id,count(question_id) as like_answercount')
        //     ->groupBy('answer_id');
        if ($sort == "DESC") {
            $answer->orderBy('likes DESC');
        }
        if ($sort == "ASC") {
            $answer->orderBy('likes ASC');
        }
        if ($sort == "ALL") {
            $answer->orderBy('rank DESC');
        }
        // $answer->leftJoin(['likes' => $answerLike], 'likes.answer_id = answers.id');

        foreach ($answer->all() as $item) {
            $status = 1;
            $result .= $this->renderAjax("@app/widgets/views/answers/_view", ["answer" => $item, "question_id" => $id, "orderWinner" => $item->rank]);
        }
        return \yii\helpers\Json::encode(
            [
                'status' => $status,
                'result' => $result,
                'sort' => $sort,
            ]
        );
    }
}
