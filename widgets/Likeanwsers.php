<?php

namespace app\widgets;

use Yii;
use app\models\LikeAnswers;
use app\models\Answers;
use yii\helpers\Html;
class Likeanwsers extends \yii\bootstrap5\Widget
{
    public $question_id=0;
    public $user_id=0;
    public $like_submit = '';
    public function init()
    {
        parent::init();
        if(isset(\Yii::$app->user->identity->id)){
            $this->user_id=\Yii::$app->user->identity->id;
        }
    }
    public function run()
    {
        $sql = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM like_answer WHERE id_questions=:QUESTION_ID",["QUESTION_ID"=>$this->question_id])->queryOne();
        return '<p class="like_answer">'.Html::encode($sql['count']).'</p>';
    }
    
}
