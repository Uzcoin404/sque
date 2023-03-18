<?php

namespace app\modules\text\models;
use app\modules\scenes\models\BookScenes;
use app\modules\books\models\Books;
use Yii;

/**
 * This is the model class for table "book_text".
 *
 * @property float $id
 * @property int $date
 * @property int $id_scenes
 * @property string $text
 * @property float $length
 *
 * @property BookScenes $BookScenes
 */
class BookText extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_text';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'id_scenes', 'text', 'length'], 'required'],
            [['date', 'id_scenes','sort'], 'integer'],
            [['text','hash'], 'string'],
            [['length'], 'number'],
            [['id_scenes'], 'exist', 'skipOnError' => true, 'targetClass' => BookScenes::className(), 'targetAttribute' => ['id_scenes' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'id_scenes' => 'Книга Chapter',
            'text' => 'Text',
            'length' => 'Length',
        ];
    }

    /**
     * Gets query for [[BookScenes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookScenes()
    {
        return $this->hasOne(BookScenes::className(), ['id' => 'id_scenes']);
    }

    public function getScene()
    {
        return $this->hasOne(BookScenes::className(), ['id' => 'id_scenes']);
    }


    public static function getCountWordsPerDay(){
        try {
            $d_start = strtotime(date('Y-m-d 00:00:00'));
            $d_end = strtotime(date('Y-m-d 23:59:59'));
            $user=Yii::$app->user->identity;
            $active_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,"main"=>1])->one();
            if(!isset($active_book->id)) return 0;
            $datas=BookScenes::find()->where(['id_book'=>$active_book->id, 'status'=>1])->all();
            if(!isset($datas)) return 0;
            $scenes=0;
            foreach($datas as $data){
                $last=Yii::$app->db->createCommand('SELECT length FROM book_text WHERE  date<:d_start and id_scenes=:scene order by date DESC', ['d_start' => $d_start,'scene' => $data->id])->queryOne();
                $now=Yii::$app->db->createCommand('SELECT length FROM book_text WHERE date>=:d_start and date<=:d_end and id_scenes=:scene order by date DESC' , ['d_start' => $d_start,'d_end'=>$d_end,'scene' => $data->id])->queryOne();
                $start=0;
                $end=0;
                if(isset($last['length']) && $last['length']>0){
                    $start=(int)$last['length'];
                }
                if(isset($now['length']) && $now['length']>0){
                    $end=(int)$now['length'];
                }
                if($end>$start){
                    $scenes+=($end-$start);
                }
            }
            return $scenes;
        } catch (Exception $e) {
            return 0;
        }
       
        
    }

    public function getCountWordsBook(){
        $user=Yii::$app->user->identity;
        $active_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one();
        if(!isset($active_book->id)) return 0;
        $datas=BookScenes::find()->where(['id_book'=>$active_book->id, 'status'=>1])->all();
        $scenes=0;
        foreach($datas as $data){
            $max=Yii::$app->db->createCommand('SELECT length FROM book_text WHERE id_scenes = :scene order by date DESC', ['scene' => $data->id])->queryOne();
            if( isset($max['length']) && is_numeric($max['length'])){
                $abs=(int)$max['length'];
             
                    $scenes+=$abs;

                
            }
            
        }
        
       return $scenes;
    }

    public function getStartDate(){
        $user=Yii::$app->user->identity;
        $active_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one();
        if(!isset($active_book->id)) return 0;
        return $active_book->date_create;
    }

    public function getBookDateEnd(){
        $user=Yii::$app->user->identity;
        $active_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one();
        if(!isset($active_book->id)) return 0;
        return $active_book->date_end;
    }

    public function getBookPlanWords(){
        $user=Yii::$app->user->identity;
        $active_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one();
        if(!isset($active_book->id)) return 0;
        return $active_book->plan_words;
    }
    public function getBookName(){
        $user=Yii::$app->user->identity;
        $active_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one();
        if(!isset($active_book->id)) return 0;
        return $active_book->name;
    }
    public function getScenesName(){
        return $this->scene->name;
    }

    public function getScenesColor(){
        return $this->scene->getGroupColor();
    }

    public function getGroup($id_scenes){
        return BookScenes::find()->where(["id"=>$id_scenes])->one();
    }
}
