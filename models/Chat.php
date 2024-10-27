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

class Chat extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'chat';
    }
    public function rules()
    {
        return [
            [['sender_id','recipient_id'], 'required',],
            [['sender_id','recipient_id','data','status','reading_users'],'integer'],
            [['img'],'string'],
            [['text'],'string'],
            [['sender_id'],'safe']
        ];
    }

    public static function GetNoRead($user_id){

        return Chat::find()->where(["sender_id"=>$user_id,"status"=>1])->count();
    }
    public static function GetUserNoRead(){

        return Chat::find()->where(["recipient_id"=>Yii::$app->user->identity,"reading_users"=>0])->count();
    }

    public static function GetAllNoRead(){

        return Chat::find()->where(["status"=>1])->count();
    }

    public static function LastData($user_id){

    
            return Chat::find()->where(["sender_id"=>$user_id])->orderBy(["data"=>SORT_DESC])->one()->created_at;
        
    }

}
