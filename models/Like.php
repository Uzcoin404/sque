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
            [['id_questions'], 'required',],
            [['id_questions','data'],'integer'],
            [['id_user'],'safe']
        ];
    }

}
