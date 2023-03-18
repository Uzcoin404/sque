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
class Pay extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'pay';
    }
    public function rules()
    {
        return [
            [['user_id','coast','status','date','count_day'], 'required',],
        ];
    }
    

}
