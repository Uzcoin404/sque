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
            [['name'],'string'],
        ];
    }
    

}
