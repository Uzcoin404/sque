<?php

namespace app\widgets;

use Yii;
use app\models\Views;
use app\models\Questions;
use yii\helpers\Html;
class Viewspost extends \yii\bootstrap5\Widget
{
    public $question_id=0;
    public $addView=0;
    public $user_id=0;
    public $type_user_id=1;
    public $admin = 0;
    public function init()
    {
        parent::init();
        if(isset(\Yii::$app->user->identity->id)){
            $this->user_id=\Yii::$app->user->identity->id;
            $this->type_user_id=1;
            $this->admin = \Yii::$app->user->identity->moderation;
        }else{
            $this->user_id=Yii::$app->session->getId();
            $this->type_user_id=0;
            $this->admin = 0;
        }
    }
    public function run()
    {
        $this->AddUserView();
        $sql = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM views WHERE question_id=:QUESTION_ID",["QUESTION_ID"=>$this->question_id])->queryOne();
        return '<p class="views">'.Html::encode($sql['count']).' '.\Yii::t('app','Views').'</p>';
    }

    private function AddUserView(){
        
        if(!$this->addView) return 0;
     
        $Question = Questions::find()->where(["id"=>$this->question_id])->one();
        
        if($this->admin == 1) return 0;

        if($Question->status == 6) return 0;

        if(isset($Question->id)) return 0;
    
        $Views=Views::find()->where(["question_id"=>$this->question_id,"type_user"=>$this->type_user_id,"user_id"=>$this->user_id])->one();
            if(!isset($Views->id)){
                $Views=new Views();
                $Views->question_id=$this->question_id;
                $Views->type_user=$this->type_user_id;
                $Views->user_id=$this->user_id;
                $Views->created_at=time();
                $Views->isNewRecord=1;
                $Views->save();
            }
    }

    
}
