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

class ViewsAnswers extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'answers_view';
    }
    public function rules()
    {
        return [
            [['answer_id'], 'required'],
            [['created_at','user_type','answer_id'],'integer'],
            [['user_id'],'safe']
        ];
    }

}
