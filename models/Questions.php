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

/* 
СТАТУСЫ
0 - Черновик, отправлен на модерация
1 - на модуарции
2 - возвращен
3 - Готов к публикации
4 - Опубликован, можно отвечать
5 - Опубликован, отвечать нельзя
6 - Вопрос Закрыт, выплаты нет
7 - Вопрос закрыт, оплачен
*/
class Questions extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'questions';
    }
    public function rules()
    {
        return [
            [['title','text','coast','status','data','owner_id'], 'required',],
            [['title'],'string'],
            [['text'],'string'],
            [['coast'], 'double', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]*\s*$/'],
            [['status','data','owner_id'],'integer'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'title' => \Yii::t('app', 'Title of question'),
            'text' => \Yii::t('app', 'Text of question'),
            'coast' => \Yii::t('app', 'Coast of question'),
            'status' => \Yii::t('app', 'Status of question'),
            'data' => \Yii::t('app', 'Data created of question'),
            'owner_id' => \Yii::t('app', 'Owner of question'),
        ];
    }

}
