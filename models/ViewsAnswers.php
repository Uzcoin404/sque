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

class ViewsAnswers extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'views_answer';
    }
    public function rules()
    {
        return [
            [['id_answer'], 'required',],
            [['data','type_user','id_answer'],'integer'],
            [['id_user'],'safe']
        ];
    }

}