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
    public function run()
    {
        $user=Yii::$app->user->identity;
        $answers = Answers::find()->where(["id_questions"=>$this->question_id])->andWhere(['<>','id_user', $user->id])->all();

        if($this->show_my){
            $answers = Answers::find()->where(["id_questions"=>$this->question_id,"id_user"=>$user->id])->all();
        }
        if($answers){
            return $this->render("answers/index",["answers"=>$answers,"id_questions"=>$this->question_id]);
        }
       
    }



}
