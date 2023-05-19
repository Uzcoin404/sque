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

class Price extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'price';
    }
    public function rules()
    {
        return [
            [['money'], 'required',],
            [['money'], 'double', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]*\s*$/'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'money' => \Yii::t('app', 'Price change'),
        ];
    }

}
