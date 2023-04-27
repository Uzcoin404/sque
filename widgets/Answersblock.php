<?php

namespace app\widgets;

use Yii;
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

        if(!$user){
            $user = User::find()->one();
        }

        $answers = Answers::find()->where(["id_questions"=>$this->question_id])->andWhere(['<>','id_user', $user->id]);

        if($this->show_my){
            $answers = Answers::find()->where(["id_questions"=>$this->question_id,"id_user"=>$user->id]);
        }
        if($this->orderWinner){
            $answers->orderBy(["number"=>SORT_ASC]);
        }
        if($answers){
            return $this->render("answers/index",["answers"=>$answers->all(),"id_questions"=>$this->question_id,"orderWinner"=>$this->orderWinner]);
        }
       
    }



}
