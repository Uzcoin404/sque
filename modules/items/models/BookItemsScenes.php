<?php

namespace app\modules\items\models;
use app\modules\items\models\BookItems;
use app\modules\books\models\Books;
use yii\helpers\ArrayHelper;
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
class BookItemsScenes extends \yii\db\ActiveRecord
{
    public $group;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_items_scenes';
    }

    public function rules()
    {
        return [
            [[ 'id_user','id_scenes','id_items'], 'required','message'=>'Поле "{attribute}" не может быть пустым'],
            [['id_user','id_scenes','id_items'], 'integer'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_items' => 'Предмет',
        ];
    }
    
    public function getItem()
    {
        return $this->hasOne(BookItems::className(), ['id' => 'id_items']);
    }



    public function getAllItems($scenes)
    { 
        $user = Yii::$app->user->identity;
        $id_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
        // 11-12-2021
        $objs_in_scenes=BookItemsScenes::find()->where(["id_scenes"=>$scenes])->all();
        $not_int_obj=[];
        foreach($objs_in_scenes as $obj_in_scenes){
            $not_int_obj[]=$obj_in_scenes->id_items;
        }
        $groups = BookItems::find()->where(["id_book"=>$id_book,"status"=>1])->andWhere(['not in','id',$not_int_obj])->all();
        // 11-12-2021
        return  ArrayHelper::map($groups,'id','name');

    }

    public function getPopover($text=false){
        if($text){
            return $this->item->getPopover($text);
        }
        return $this->item->getPopover();
    }
}
