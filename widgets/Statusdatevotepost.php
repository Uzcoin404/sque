<?php

namespace app\widgets;

use Yii;
use app\models\Questions;
use yii\helpers\Html;
class Statusdatevotepost extends \yii\bootstrap5\Widget
{
    public $question_id=0;
    public $addView=0;
    public $user_id=0;
    public $type_user_id=1;
    public $admin = 0;
    public function init()
    {
        parent::init();
    }
    public function run()
    {   
        $sql = Yii::$app->getDb()->createCommand("SELECT * FROM questions WHERE id=:ID",["ID"=>$this->question_id])->queryOne();
        return '<p class="voting_text">'.Yii::t('app','Was on voiting').' : '.Html::encode($this->DateStatus($sql['data_open'],$sql['data_status'])).'</p>';
    }

    private function DateStatus($date,$date_status){
        $first_date = new \DateTime("@".$date);
        $second_date = new \DateTime("@".$date_status);
        $interval = $first_date->diff($second_date);
        if($interval->days <= 0){
            return \Yii::t('app', '{h} hours {i} minutes',['h'=>$interval->h,'i'=>$interval->i]);
        } else {
            $hours = $interval->d * 24 + $interval->h;
            return \Yii::t('app', '{h} hours {i} minutes',['h'=>$hours,'i'=>$interval->i]);
        }
    }
}
