<?php

namespace app\widgets;

use Yii;
use app\models\Questions;
use yii\helpers\Html;
class Statusdatepost extends \yii\bootstrap5\Widget
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
        return '<p class="open_text">'.Yii::t('app','Was opened').' : ' .Html::encode($this->DateStatus($sql['data'],$sql['data_open'])).'</p>';
    }

    private function DateStatus($date,$date_status){
        $first_date = new \DateTime("@".$date);
        $second_date = new \DateTime("@".$date_status);
        $interval = $first_date->diff($second_date);
        if($interval->days <= 0){
            $result= \Yii::t('app','{h} hours',['h'=>$interval->h]);
        } else {
            $result= \Yii::t('app', '{d} days {h} hours',['d'=>$interval->d,'h'=>$interval->h]);
        }

        if($interval->days <= 0){
            return \Yii::t('app','{h} hours',['h'=>$interval->h]);
        } else {
            return \Yii::t('app', '{d} days {h} hours',['d'=>$interval->d,'h'=>$interval->h]);
        }
    }
}
