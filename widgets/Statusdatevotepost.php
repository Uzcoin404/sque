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
    public $user_type_id=1;
    public $admin = 0;
    public function init()
    {
        parent::init();
    }
    public function run()
    {
        if ($this->question_id == null) {
            return '<p class="voting_text">'.Yii::t('app','Was on voiting').' : '.Html::encode(Questions::WasVoting($this->question_id)).'</p>';
        }   
    }


}
