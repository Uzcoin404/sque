<?php

namespace app\widgets;

use Yii;
use app\models\Questions;
use app\models\Answers;
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


        $answers = Answers::find()->where(["id_questions"=>$this->question_id]);
        $question_status = Questions::find()->where(["id"=>$this->question_id])->one();
       
        if($question_status->status == 4){
            if($user){
                $answers = Answers::find()->where(["id_questions"=>$this->question_id,"id_user"=>$user->id]);
                return $this->render("answers/index",["answers"=>$answers->all(),"id_questions"=>$this->question_id,"orderWinner"=>$this->orderWinner]);
            } else {
                return;
            }
        }

        if($this->orderWinner){
            $answers->orderBy(["number"=>SORT_ASC]);
        }

        if($answers){
            return $this->render("answers/index",["answers"=>$answers->all(),"id_questions"=>$this->question_id,"orderWinner"=>$this->orderWinner]);
        }
       
    }



}
