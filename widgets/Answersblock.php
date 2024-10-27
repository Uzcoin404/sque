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
    public $question_id=0;
    public $show_my=0;
    public $orderWinner=0;
    public function run()
    {
        $user=Yii::$app->user->identity;

        $answers = Answers::find()->where(["question_id"=>$this->question_id]);
        $question_status = Questions::find()->where(["id"=>$this->question_id])->one();
       
        if($question_status->status >= 5){
            $answers = Answers::find()->where(["question_id"=>$this->question_id]);
            $answers->orderBy('views_answer.views_answercount ASC');
            
            $answerlike = ViewsAnswers::find()
            ->select('id_answer,count(user_id) as views_answercount')
            ->groupBy('id_answer');
            $answers->leftJoin(['views_answer'=>$answerlike], 'views_answer.id_answer = answers.id');
            if($this->orderWinner){

                $answers->orderBy('views_answer.views_answercount ASC, dislikes_answer.views_dislaikanswercount as ASC');
                $answerlike = DislikeAnswer::find()
                ->select('id_answer,count(user_id) as views_answercount')
                ->groupBy('id_answer');
                $answers->leftJoin(['dislikes_answer'=>$answerlike], 'dislikes_answer.id_answer = answers.id');
            }
            
        }
       
        if($question_status->status == 4){
            if($user){
                $answers = Answers::find()->where(["question_id"=>$this->question_id,"user_id"=>$user->id]);
                return $this->render("answers/index",["answers"=>$answers->all(),"question_id"=>$this->question_id,"orderWinner"=>$this->orderWinner, "filter_status"=>0]);
            } else {
                return;
            }
        }

        if($this->orderWinner){
            $answers->orderBy(["number"=>SORT_ASC]);
        }

        if($answers){
            return $this->render("answers/index",["answers"=>$answers->all(),"question_id"=>$this->question_id,"orderWinner"=>$this->orderWinner, "filter_status"=>0]);
        }
       
    }



}
