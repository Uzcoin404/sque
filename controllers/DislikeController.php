<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\User;
use app\models\ViewsAnswers;
use app\models\Dislike;
use app\models\DislikeAnswer;
use app\models\LikeAnswers;
use app\models\ChangeEmail;
use app\models\Answers;
use app\models\Questions;
use app\widgets\Viewsanswer;


// AJAX
use yii\widgets\ActiveForm;


class DislikeController extends Controller
{
    public $info = [];
    public $user_id = [];
    public $user_info = [];
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [

                    [
                        'actions' => ['index', 'block', 'filterdislike'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    [
                        'actions' => ['block', 'filterdislike'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],

                ],
            ],

        ];
    }

    public function actionIndex()
    {
        $dislike = new Dislike();

        $request = Yii::$app->request;

        $user = Yii::$app->user->identity;

        $dislike->question_id = 12;
        $dislike->user_id = $user->id;
        $dislike->created_at = strtotime('now');

        $this->DislikeAnswers();

        $dislike->save();
    }

    public function actionFilterdislike()
    {
        // ->where(['question_id'=>$_GET['question_id']])
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $status = 0;
        $result = "";
        $data = Yii::$app->request->post();
        $sort = $data['sorts'];
        $id = $data['id'];
        $filter = 0;

        $answer = Answers::find()->where(['in', 'question_id', $id]);
        if ($sort == "DESC") {
            $answer->orderBy('dislikes.dislike_answercount DESC');
            $filter = 1;
        }
        if ($sort == "ASC") {
            $answer->orderBy('dislikes.dislike_answercount ASC');
        }
        if ($sort == "ALL") {
            $answer->orderBy('rank ASC');
        }
        $answerLike = DislikeAnswer::find()
            ->select('answer_id,count(question_id) as dislike_answercount')
            ->groupBy('answer_id');
        $answer->leftJoin(['dislikes' => $answerLike], 'dislikes.answer_id = answers.id');
        foreach ($answer->all() as $question) {
            $status = 1;
            $result .= $this->renderAjax("@app/widgets/views/answers/_view", ["answer" => $question, "question_id" => $id, "orderWinner" => $question->rank, 'filter_status' => $filter]);
        }
        return \yii\helpers\Json::encode(
            [
                'status' => $status,
                'result' => $result,
                'sort' => $sort,
            ]
        );
    }

    public function DislikeAnswers()
    {

        $request = Yii::$app->request;

        $user = Yii::$app->user->identity;

        $this->info = [
            $request->get('id_answer_dislike'),
        ];
        foreach ($this->info as $post) {
            if ($post) {
                foreach ($post as $dislike) {
                    $answer_id = $dislike['answer'];
                    $answer_views = ViewsAnswers::find()->where(["answer_id" => $answer_id, "user_id" => $user->id])->one();

                    $answer_like = LikeAnswers::find()->andWhere(["answer_id" => $answer_id, "user_id" => $user->id])->one();
                    $answer_dis = DislikeAnswer::find()->andWhere(["answer_id" => $answer_id, "user_id" => $user->id])->one();

                    if ($answer_dis) {

                        $answer_dis->changeLike();
                    } else {
                        $answer = Answers::find()->where(["id" => $answer_id])->one();
                        $question = Questions::find()->where(['id' => $dislike['question'][0]])->one();

                        if ($answer_like) {
                            $answer_like->changeLike($answer_id);
                        }

                        if ($question->status == 5) {
                            if ($answer->user_id != $user->id && $user->moderation == 0) {
                                $newDislike = new DislikeAnswer();
                                $newDislike->answer_id = $answer_id;
                                $newDislike->question_id = $dislike['question'][0];
                                $newDislike->user_id = $user->id;
                                $newDislike->status = 1;
                                $newDislike->created_at = time();
                                $newDislike->save();
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

        $answer = DislikeAnswer::find()->andWhere(['answer_id' => $this->info[0]])->all();

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
}
