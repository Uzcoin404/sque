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
        $user_id = [];
        $sql = LikeAnswers::find()->andWhere(['question_id'=>$this->question_id])->all();
        foreach($sql as $value){
            array_push($user_id, $value->user_id);
        }
        $result = array_unique($user_id);
        $count = count($result);
        return '<p class="likes">'.Html::encode($count).' '.Yii::t('app','Voitings').'</p>';
    }
    
}
