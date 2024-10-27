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

class Complaints extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'complaints';
    }
    public function rules()
    {
        return [
            [['user_id_sender','user_id','question_id','id_answers','reason','data'], 'required',],
            [['user_id_sender','user_id','question_id','id_answers','data'],'integer'],
            [['reason'],'string']
        ];
    }
    public function attributeLabels()
    {
        return [
            'reason'=> \Yii::t('app','Reason for complain'),
        ];
    }

}
