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

class Info extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'info_post';
    }
    public function rules()
    {
        return [
            [['text_ru','text_eng'], 'required',],
            [['status'],'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => \Yii::t('app', 'Title of question'),
            'text' => \Yii::t('app', 'Text of question'),
            'cost' => \Yii::t('app', 'Cost of the best answer'),
            'status' => \Yii::t('app', 'Status of question'),
            'data' => \Yii::t('app', 'Data created of question'),
            'owner_id' => \Yii::t('app', 'Owner of question'),
            'grand'=> \Yii::t('app','Country'),
            'data'=> \Yii::t('app','Date update'),
            'text_ru'=> \Yii::t('app','Text Russian'),
            'text_eng'=> \Yii::t('app','Text English'),
            'text_return'=> \Yii::t('app','Reason for return'),
        ];
    }

}
