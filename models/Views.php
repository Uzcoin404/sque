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
            [['id_questions'], 'required',],
            [['id_questions','data','type_user'],'integer'],
            [['id_user'],'safe']
        ];
    }

}
