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
        return 'like_answer';
    }
    public function rules()
    {
        return [
            [['id_answer','id_questions'], 'required',],
            [['data','id_answer'],'integer'],
            [['id_user'],'safe']
        ];
    }

}
