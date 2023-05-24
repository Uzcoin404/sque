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
        $id_user = [];
        $sql = LikeAnswers::find()->where(['id_questions'=>$this->question_id])->all();
        foreach($sql as $value){
            array_push($id_user, $value->id_user);
        }
        $result = array_unique($id_user);
        $count = count($result);
        return '<p class="like_answer">'.Html::encode($count).'</p>';
    }
    
}
