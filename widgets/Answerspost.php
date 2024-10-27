<?php

namespace app\widgets;

use Yii;
use app\models\Answers;
use yii\helpers\Html;
class Answerspost extends \yii\bootstrap5\Widget
{
    public $question_id=0;
    public $user_id=0;
    public function init()
    {
        parent::init();
        if(isset(\Yii::$app->user->identity->id)){
            $this->user_id=\Yii::$app->user->identity->id;
        }
    }
    public function run()
    {
        $sql = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM answers WHERE question_id=:QUESTION_ID",["QUESTION_ID"=>$this->question_id])->queryOne();
        return '<p class="answers">'.Html::encode($sql['count']).' '.\Yii::t('app','Answers').'</p>';
    }
    
}
