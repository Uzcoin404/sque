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
        return '<p class="open_text">'.Yii::t('app','Was opened').' : ' .Html::encode($this->DateStatus($sql['data_start'],$sql['data_open'])).'</p>';
    }

    private function DateStatus($data,$date_open){
        
        $first_date = new \DateTime("@".$data);
        $second_date = new \DateTime("@".$date_open);
        $interval = $first_date->diff($second_date);
        if($interval->days <= 0){
            
            return \Yii::t('app', '{h} hours {i} minutes',['h'=>$interval->h,'i'=>$interval->i]);
        } else {
           
            $hours = $interval->d * 24 + $interval->h;
            return \Yii::t('app', '{h} hours {i} minutes',['h'=>$hours,'i'=>$interval->i]);
        }
    }
}
