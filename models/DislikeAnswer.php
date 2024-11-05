<?php

namespace app\models;

use yii\db\Expression;
use app\models\ViewsAnswers;

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
}
