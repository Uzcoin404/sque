<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\modules\books\models\Books;
use app\models\NoteGroups;
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
            [['id_questions','id_user','text'], 'required'],
            [['text'],'string'],
            [['id_questions','data'],'integer'],
            [['id_user'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => \Yii::t('app', 'Text of answer'),
        ];
    }

    public function GetUserName(){
        return User::find()->where(["id"=>$this->id_user])->one()->username;

    }

    public function GetText(){
        return $this->text;
    }

    public function getLiks(){
        $sql = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM like_answer WHERE id_answer=:ID_ANSWER",["ID_ANSWER"=>$this->id])->queryOne();
        return $sql['count'];
    }
    public function getDisliks(){
        $sql = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM dislike_answer WHERE id_answer=:ID_ANSWER",["ID_ANSWER"=>$this->id])->queryOne();
        return $sql['count'];
    }
    public function getView(){
        $sql = Yii::$app->getDb()->createCommand("SELECT COUNT(id) as count FROM views_answer WHERE id_answer=:ID_ANSWER",["ID_ANSWER"=>$this->id])->queryOne();
        return $sql['count'];
    }

}
