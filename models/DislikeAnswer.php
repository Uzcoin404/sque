<?php

namespace app\models;

use yii\db\Expression;

class DislikeAnswer extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'dislikes';
    }
    public function rules()
    {
        return [
            [['answer_id', 'question_id'], 'required',],
            [['created_at', 'answer_id'], 'integer'],
            [['user_id'], 'safe']
        ];
    }
    public static function find()
    {
        return parent::find()->where(['status' => 1]);
    }


    public function changeLike()
    {
        $this->status = !$this->status;
        return $this->save(false, ['status']);
    }
}
