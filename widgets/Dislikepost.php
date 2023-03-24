<?php

namespace app\widgets;

use Yii;
use app\models\Dislike;
use yii\helpers\Html;
class Dislikepost extends \yii\bootstrap5\Widget
{
    public $question_id=0;
    public $user_id=0;
    public $dislike_submit = '';
    public function init()
    {
        parent::init();
        if(isset(\Yii::$app->user->identity->id)){
            $this->user_id=\Yii::$app->user->identity->id;
            $this->dislike_submit = 'DislikeSubmit()';
        }
    }
    public function run()
    {
        $sql = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM dislikepost WHERE id_questions=:QUESTION_ID",["QUESTION_ID"=>$this->question_id])->queryOne();
        return '<p class="dislike"><button class="btn_dislike" onclick="'.$this->dislike_submit.'"></button>'.Html::encode($sql['count']).' '.\Yii::t('app','Dislike').'</p>';
    }
    
}
