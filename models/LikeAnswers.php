<?php

namespace app\models;

use app\models\Answers;
use yii\db\Expression;

class LikeAnswers extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'likes';
    }
    public function rules()
    {
        return [
            [['answer_id','question_id'], 'required',],
            [['created_at','answer_id'],'integer'],
            [['user_id'],'safe']
        ];
    }
    public static function find()
    {
        return parent::find()->where(['status' => 1]);
    }
    public function changeLike($answer_id)
    {
        if ($this->status == 1) {
            Answers::updateAll(['likes' => new Expression('likes - 1')], ['id' => $answer_id]);
        } else {
            Answers::updateAll(['likes' => new Expression('likes + 1')], ['id' => $answer_id]);
        }
        $this->status = !$this->status;
        return $this->save(false, ['status']);
    }
}
