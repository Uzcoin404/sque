<?php

namespace app\modules\pers\models;
use app\modules\books\models\Books;
use app\modules\pers\models\BookPers;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "book_pers_pers".
 *
 * @property int $id
 * @property int $id_pers
 * @property int $to_id_pers
 *
 * @property BookPers $pers
 * @property BookPers $toIdPers
 */
class BookPersPers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_pers_pers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pers', 'to_id_pers'], 'required'],
            [['id_pers', 'to_id_pers'], 'integer'],
            [['id_pers'], 'exist', 'skipOnError' => true, 'targetClass' => BookPers::className(), 'targetAttribute' => ['id_pers' => 'id']],
            [['to_id_pers'], 'exist', 'skipOnError' => true, 'targetClass' => BookPers::className(), 'targetAttribute' => ['to_id_pers' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_pers' => 'Id Pers',
            'to_id_pers' => 'To Id Pers',
        ];
    }

    /**
     * Gets query for [[Pers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPers()
    {
        return $this->hasOne(BookPers::className(), ['id' => 'id_pers']);
    }

    /**
     * Gets query for [[ToIdPers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getToIdPers()
    {
        return $this->hasOne(BookPers::className(), ['id' => 'to_id_pers']);
    }

    public function getAllPers()
    { 
        $user = Yii::$app->user->identity;
        $id_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
        $groups = BookPers::find()->where(["id_book"=>$id_book])->all();
        
        return  ArrayHelper::map($groups,'id','nickname');

    }
}
