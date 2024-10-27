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
