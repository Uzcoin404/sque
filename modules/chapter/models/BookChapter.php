<?php

namespace app\modules\chapter\models;
use app\modules\books\models\Books;
use Yii;

/**
 * This is the model class for table "book_chapter".
 *
 * @property int $id
 * @property int $id_book
 * @property string $name
 *
 * @property Book $book
 */
class BookChapter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_chapter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_book', 'name'], 'required'],
            [['id_book'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_book'], 'exist', 'skipOnError' => true, 'targetClass' => Books::className(), 'targetAttribute' => ['id_book' => 'id']],
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
            'name' => 'Name',
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
}
