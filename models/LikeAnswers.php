<?php

namespace app\models;

use app\models\Answers;
use yii\db\Expression;
use app\models\ViewsAnswers;

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
}
