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

class Answers extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'answers';
    }
    public function rules()
    {
        return [
            [['id_questions','id_user','text'], 'required'],
            [['text'],'string'],
            [['id_questions','data'],'integer'],
            [['id_user'], 'safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'text' => \Yii::t('app', 'Text of answer'),
        ];
    }

}
