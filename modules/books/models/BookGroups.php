<?php

namespace app\modules\books\models;

use Yii;

/**
 * This is the model class for table "book_groups".
 *
 * @property int $id
 * @property string $name
 * @property int $id_user
 * @property string|null $image
 * @property string|null $annotation
 */
class BookGroups extends \yii\db\ActiveRecord
{
    public $imageFile;
    public static function tableName()
    {
        return 'book_groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'id_user'], 'required'],
            [['id_user','isDefault'], 'integer'],
            [['annotation'], 'string'],
            [['name'], 'string', 'max' => 40],
            [['image'], 'string', 'max' => 45],
            [['color'], 'string', 'max' => 9],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg','wrongExtension'=>"Выбран не верный формат"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название группы книг',
            "color"=>'Цвет группы книг',
            'id_user' => 'Id User',
            'image' => 'Image',
            'annotation' => 'Annotation',
        ];
    }
    public function upload()
    {
        if ($this->validate()) {
            $user=Yii::$app->user->identity;
            $name=MD5($user->id."".strtotime('now')."".$this->imageFile->baseName) . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs(Yii::getAlias('@webroot').'/img/books-groups/' .$name) ;
            return $name;
        } else {
            return false;
        }
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
