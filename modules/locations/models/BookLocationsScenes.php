<?php

namespace app\modules\locations\models;
use app\modules\locations\models\BookLocations;
use yii\helpers\ArrayHelper;
use app\modules\books\models\Books;
use Yii;

/**
 * This is the model class for table "book_items".
 *
 * @property int $id
 * @property int $id_book
 * @property string $name
 * @property string $description
 *
 * @property Books $book
 */
class BookLocationsScenes extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'book_locations_scenes';
    }

    public function rules()
    {
        return [
            [[ 'id_user','id_scenes','id_locations'], 'required','message'=>'Поле "{attribute}" не может быть пустым'],
            [['id_user','id_scenes','id_locations'], 'integer'],

        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_locations' => 'Локации',
        ];
    }

    
    public function getLocation()
    {
        return $this->hasOne(BookLocations::className(), ['id' => 'id_locations']);
    }



    public function getAllLocations($scenes)
    { 
        $user = Yii::$app->user->identity;
        $id_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
        // 11-12-2021
        $objs_in_scenes=BookLocationsScenes::find()->where(["id_scenes"=>$scenes])->all();
        $not_int_obj=[];
        foreach($objs_in_scenes as $obj_in_scenes){
            $not_int_obj[]=$obj_in_scenes->id_locations;
        }
        $groups = BookLocations::find()->where(["id_book"=>$id_book,"status"=>1])->andWhere(['not in','id',$not_int_obj])->all();
        // 11-12-2021
        return  ArrayHelper::map($groups,'id','name');

    }

    public function getPopover($text=false){
        if($text){
            return $this->location->getPopover($text);
        }
        return $this->location->getPopover();
    }
}
