<?php

namespace app\widgets;

use Yii;
use app\models\Answers;
use app\models\ViewsAnswers;
use app\models\User;
use yii\helpers\Html;
class Answersblock extends \yii\bootstrap5\Widget
{
    public $question_id=0;
    public $status=0;
    public $user_id=0;
    public $number=0;
    public function init()
    {
        parent::init();
    }
    public function run()
    {
        $answers = Answers::find()->where(["id_questions"=>$this->question_id])->all();
        $i = $this->number;
        foreach($answers as $post){
            
            $user = $post->id_user;
            $id = $post->id;

            echo 
            "
            <div class='answers_post__list_element'>
                <p class='title' data-id='".$post->id_user."'>".$this->Users($user)."</p>
                <p class='text'>".$post->text."</p>
                <div class='answers_post__list_element_text_price_full'>
                    ".$this->LikeAnswers($i, $id, $user)."
                    ".$this->DislikeAnswers($i, $id, $user)."
                </div>
            ";
            $i++;
        }
    }

    public function Users($user){
        $name = User::find()->where(["id"=>$user])->one();
        return $name->username;
    }
    
    public function LikeAnswers($i, $id, $user){
        if($this->status == 5){
            $sql = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM like_answer WHERE id_answer=:ID_ANSWER",["ID_ANSWER"=>$id])->queryOne();
            return '<p class="like_answer"><button class="btn_like_answer block'.$i.'" data-id="'.$id.'"></button>'.Html::encode($sql['count']).' '.\Yii::t('app','Like').'</p>';
        }
    }

    public function DislikeAnswers($i, $id, $user){
        if($this->status == 5){
            $sql = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM dislike_answer WHERE id_answer=:ID_ANSWER",["ID_ANSWER"=>$id])->queryOne();
            return '<p class="dislike_answer"><button class="btn_dislike_answer block'.$i.'" data-id="'.$id.'"></button>'.Html::encode($sql['count']).' '.\Yii::t('app','Dislike').'</p>';
        }
    }

}
