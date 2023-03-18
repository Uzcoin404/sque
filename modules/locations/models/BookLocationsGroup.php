<?php

namespace app\modules\locations\models;
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
class BookLocationsGroup extends \yii\db\ActiveRecord
{
    public $group;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_locations_group';
    }

    /**
     * {@inheritdoc}
     */
     public function rules()
    {
        return [
            [['name', 'id_user','id_book'], 'required'],
            [['id_user','id_book','isDefault'], 'integer'],
            [['name'], 'string', 'max' => 40],
            [['color'], 'string', 'max' => 9],

        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_book' => 'Книга',
            'name' => 'Название группы локаций',
            'color'=>'Цвет группы локаций',
            'description' => 'Описание',
   
        ];
    }

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Books::className(), ['id' => 'id_book']);
    }

    public function getBooks()
    { 
        $user=Yii::$app->user->identity;
        $groups = Books::find()->where(["id_user"=>$user->id])->all();
        
        return ArrayHelper::map($groups,'id','name');

    }

    
    public function getGroupsList()
    { 
        $user=Yii::$app->user->identity;
        $book_id=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
        $groups = BookGroups::find()->where(["id_user"=>$user->id,'status'=>1,'id_book'=> $book_id])->all();
        
        return ArrayHelper::map($groups,'id','name');

    }

    public static function getColorList(){
        return [
            "#00aba922"=>"#00aba9",
            "#0050ef22"=>"#0050ef",
            "#aa00ff22"=>"#aa00ff",
            "#d8007322"=>"#d80073",
            "#64768722"=>"#647687",

        ];
    }

    public function afterFind(){
        parent::afterFind();
        $this->name=strip_tags($this->name);
    }
}
