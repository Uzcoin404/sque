<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\Url;
class ChangeEmail extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'users_emails';
    }

    public function rules()
    {
        return [
            [['email','user_id','status','hash'], 'required'],
            [['email','hash'], 'string', 'max' => 255],
            [['status','user_id','date'], 'integer'],
        ];
    }

    public function getEmailText(){
        return "Вы пытались сделать смену электнонной почты. Для подтверждения перейдите по ссылке: https://service.my-novel.online/ChangeEmail/".$this->hash;
    }

}
