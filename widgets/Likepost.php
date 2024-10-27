<?php

namespace app\widgets;

use Yii;
use app\models\Like;
use yii\helpers\Html;
class Likepost extends \yii\bootstrap5\Widget
{
    public $question_id=0;
    public $user_id=0;
    public $like_submit = '';
    public function init()
    {
        parent::init();
        if(isset(\Yii::$app->user->identity->id)){
            $this->user_id=\Yii::$app->user->identity->id;
            $this->like_submit = 'LikeSubmit()';
        }
    }
    public function run()
    {
        $sql = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM likepost WHERE question_id=:QUESTION_ID",["QUESTION_ID"=>$this->question_id])->queryOne();
        return '<p class="like"><button class="btn_like" onclick="VoteSave('.$this->question_id.')"></button>'.Html::encode($sql['count']).' '.\Yii::t('app','Like').'</p>';
    }
    
}
