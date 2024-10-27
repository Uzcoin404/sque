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

class Like extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'likepost';
    }
    public function rules()
    {
        return [
            [['question_id'], 'required',],
            [['question_id','created_at'],'integer'],
            [['user_id'],'safe']
        ];
    }

}
