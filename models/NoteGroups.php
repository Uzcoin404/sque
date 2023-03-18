<?php

namespace app\models;

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
use yii\helpers\ArrayHelper;
class NoteGroups extends \yii\db\ActiveRecord
{
    public $imageFile;
    public static function tableName()
    {
        return 'note_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'id_user','id_book'], 'required'],
            [['id_user','isDefault'], 'integer'],
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
            'name' => 'Название группы заметок',
            "color"=>'Цвет группы заметок',
            'id_user' => 'Id User',
            'image' => 'Image',
            'annotation' => 'Annotation',
        ];
    }


    public function getColorList(){
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
