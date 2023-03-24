<?php

namespace app\widgets;

use Yii;
use app\models\ViewsAnswers;
use yii\helpers\Html;
class Viewsanswer extends \yii\bootstrap5\Widget
{
    public $question_id=0;
    public $id_answer = 0;
    public $addView=0;
    public $user_id=0;
    public $type_user_id=1;
    public function init()
    {
        parent::init();
        if(isset(\Yii::$app->user->identity->id)){
            $this->user_id=\Yii::$app->user->identity->id;
            $this->type_user_id=1;
        }else{
            $this->user_id=Yii::$app->session->getId();
            $this->type_user_id=0;
        }
    }
    public function run()
    {
        $this->AddUserView();
        $sql = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM views WHERE id_answer=:ID_ANSWER",["ID_ANSWER"=>$this->question_id])->queryOne();
        return '<p class="views">'.Html::encode($sql['count']).' '.\Yii::t('app','Views').'</p>';
    }

    private function AddUserView(){
        if(!$this->addView) return 0;
       
        $Views=Views::find()->where(["id_questions"=>$this->question_id,"type_user"=>$this->type_user_id,"id_user"=>$this->user_id])->one();
      
        if(!isset($Views->id)){
            $Views=new ViewsAnswers();
            $Views->id_questions=$this->question_id;
            $Views->type_user=$this->type_user_id;
            $Views->id_user=$this->user_id;
            $Views->data=strtotime("now");
            $Views->isNewRecord=1;
            $Views->save();
        }
    }

    
}
