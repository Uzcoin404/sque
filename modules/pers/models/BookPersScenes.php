<?php

namespace app\modules\pers\models;
use app\modules\pers\models\BookPers;
use yii\helpers\ArrayHelper;
use app\modules\books\models\Books;
use Yii;

class BookPersScenes extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'book_pers_scenes';
    }
    public function rules()
    {
        return [
            [[ 'id_user','id_scenes','id_pers'], 'required','message'=>'Поле "{attribute}" не может быть пустым'],
            [['id_user','id_scenes','id_pers'], 'integer'],

        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_pers' => 'Персонаж',
        ];
    }

    
    public function getPer()
    {
        return $this->hasOne(BookPers::className(), ['id' => 'id_pers']);
    }



    public function getAllPers($scenes)
    { 
        $user = Yii::$app->user->identity;
        $id_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
        // 11-12-2021
        $objs_in_scenes=BookPersScenes::find()->where(["id_scenes"=>$scenes])->all();
        $not_int_obj=[];
        foreach($objs_in_scenes as $obj_in_scenes){
            $not_int_obj[]=$obj_in_scenes->id_pers;
        }
        $groups = BookPers::find()->where(["id_book"=>$id_book,"status"=>1])->andWhere(['not in','id',$not_int_obj])->all();
        // 11-12-2021
        return  ArrayHelper::map($groups,'id','nickname');

    }
   

    public function getPopover($text=false){
        return $this->per->getPopover($text);
    }
}
