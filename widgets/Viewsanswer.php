<?php

namespace app\widgets;

use Yii;
use app\models\ViewsAnswers;
use yii\helpers\Html;
class Viewsanswer extends \yii\bootstrap5\Widget
{
    public function init()
    {
        parent::init();
    }
    public function run()
    {
        $sql = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM views WHERE id_answer=:ID_ANSWER",["ID_ANSWER"=>$this->answers])->queryOne();
        return '<p class="views">'.Html::encode($sql['count']).' '.\Yii::t('app','Views').'</p>';
    }

    
}
