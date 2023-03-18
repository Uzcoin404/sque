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
class Grand extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'grand';
    }
    public function rules()
    {
        return [
            [['name','status'], 'required',],
            [['name'],'string'],
        ];
    }
    

}
