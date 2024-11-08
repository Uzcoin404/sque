<?php

namespace app\widgets;

use Yii;
use app\models\Questions;
use app\models\Answers;
use app\models\DislikeAnswer;
use app\models\ViewsAnswers;
use app\models\User;

class Answersblock extends \yii\bootstrap5\Widget
{
    public $question_id = 0;
    public $show_my = 0;
    public $orderWinner = 0;
    public function run()
    {
        $user = Yii::$app->user->identity;
        $answers = Answers::find()->where(["question_id" => $this->question_id]);

        $question_status = Questions::find()->where(["id" => $this->question_id])->one();

        if ($question_status->status >= 5) {

            $answers->orderBy(['answers_view.answers_viewcount ASC']);

            $answerViews = ViewsAnswers::find()
                ->select(['answer_id', 'count(user_id) as answers_viewcount', 'MAX(created_at) as latest_view_time'])
                ->groupBy('answer_id');

            // Join the subquery and order by views count first, and latest view time second
            $answers->leftJoin(['answers_view' => $answerViews], 'answers_view.answer_id = answers.id')
                ->orderBy([
                    'answers_view.answers_viewcount' => SORT_ASC, // Sort by view count in ascending order
                    'answers_view.latest_view_time' => SORT_DESC   // Sort by latest view time in descending order if view counts are the same
                ]);
            if ($this->orderWinner) {

                $answers->orderBy('answers_view.answers_viewcount ASC, dislikes_answer.views_dislaikanswercount as ASC');
                $answerlike = DislikeAnswer::find()
                    ->select('answer_id,count(user_id) as answers_viewcount')
                    ->groupBy('answer_id');
                $answers->leftJoin(['dislikes_answer' => $answerlike], 'dislikes_answer.answer_id = answers.id');
            }
        }

        if ($question_status->status == 4) {
            if ($user) {
                $answers = Answers::find()->where(["question_id" => $this->question_id, "user_id" => $user->id]);
                return $this->render("answers/index", ["answers" => $answers->all(), "question_id" => $this->question_id, "orderWinner" => $this->orderWinner, "filter_status" => 0]);
            } else {
                return;
            }
        }

        if ($this->orderWinner) {
            $answers->orderBy("rank ASC");
        }
        if ($answers) {
            return $this->render("answers/index", ["answers" => $answers->all(), "question_id" => $this->question_id, "orderWinner" => $this->orderWinner, "filter_status" => 0]);
        }
    }
}
