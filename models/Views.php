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

class Views extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'views';
    }
    public function rules()
    {
        return [
            [['question_id'], 'required',],
            [['question_id','created_at','user_type'],'integer'],
            [['user_id'],'safe']
        ];
    }

}
