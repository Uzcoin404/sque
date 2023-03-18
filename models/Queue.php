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
class Queue extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'queue';
    }
    public function rules()
    {
        return [
            [['id_model','type','status'], 'required',],
            [['value'],'string'],
        ];
    }
    

}
