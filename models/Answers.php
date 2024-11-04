<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\modules\books\models\Books;
use app\models\NoteGroups;
use app\models\LikeAnswers;
use yii\helpers\ArrayHelper;

class Answers extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'answers';
    }
    public function rules()
    {
        return [
            [['question_id','user_id','text'], 'required'],
            [['text'],'string'],
            [['question_id','created_at','rank'],'integer'],
            [['user_id'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => \Yii::t('app', 'Text of answer'),
        ];
    }

    public function GetUserName(){
        return User::find()->where(["id"=>$this->user_id])->one()->username;

    }

    public function GetText(){
        $text = mb_strimwidth($this->text, 0, 30, "...");
        return $text;
    }

    public function getLiks(){
        return Answers::find('likes')->where(['id' => $this->id])->one()->likes;
        // $sql = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM likes WHERE answer_id=:answer_id",["answer_id"=>$this->id, 'status' => 1])->queryOne();
        // return $sql['count'];
    }
    public function getDisliks(){
        return DislikeAnswer::find()->count();
    }
    public function getView(){
        $sql = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM answers_view WHERE answer_id=:answer_id",["answer_id"=>$this->id])->queryOne();
        return $sql['count'];
    }

}
