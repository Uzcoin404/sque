<?php

namespace app\widgets;

use Yii;
use app\models\Questions;
use app\models\ViewsAnswers;
use app\models\User;

class AnswerNameUser extends \yii\bootstrap5\Widget
{
    public $question_id=0;

    public function run()
    {
        $questions = Questions::find()->where(["id"=>$this->question_id])->all();
        foreach($questions as $question){
            $user = User::find()->where(["id"=>$question->owner_id])->one();
            return $user->username;
        }
       
    }



}
