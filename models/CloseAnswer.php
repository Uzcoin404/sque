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

class CloseAnswer extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'close_answers';
    }
    public function rules()
    {
        return [
            [['id','user_id','answer_id','question_id'], 'required',],
            [['id','user_id','answer_id','question_id'],'integer'],
        ];
    }

}
