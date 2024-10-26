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
        if ($this->question_id == null) {
            return '<p class="open_text">'.Yii::t('app','Was opened').' : ' .Html::encode(Questions::WasOpened($this->question_id)).'</p>';
        }   
    }

   
}
