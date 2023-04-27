<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\modules\books\models\Books;
use app\models\NoteGroups;
use yii\helpers\ArrayHelper;

/* 
СТАТУСЫ
0 - Черновик, отправлен на модерацию
1 - На модерации
2 - Возвращен
3 - Готов к публикации
4 - Опубликован, можно отвечать
5 - Опубликован, отвечать нельзя
6 - Вопрос Закрыт, выплаты нет
7 - Вопрос закрыт, оплачен
8 - Отказ
*/
class Questions extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'questions';
    }
    public function rules()
    {
        return [
            [['title','text','coast','status','data','owner_id','grand','data_status'], 'required',],
            [['title'],'string'],
            [['text'],'string'],
            [['coast'], 'double', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]*\s*$/'],
            [['status','data','owner_id'],'integer'],
            [['grand'], 'string'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'title' => \Yii::t('app', 'Title of question'),
            'text' => \Yii::t('app', 'Text of question'),
            'coast' => \Yii::t('app', 'Coast of question'),
            'status' => \Yii::t('app', 'Status of question'),
            'data' => \Yii::t('app', 'Data created of question'),
            'owner_id' => \Yii::t('app', 'Owner of question'),
            'grand'=> \Yii::t('app','Country'),
        ];
    }

    public function getStatusList()
    {
        return [
            0 => \Yii::t('app', 'Draft'),
            1 => \Yii::t('app', 'Submitted for moderation'),
            2 => \Yii::t('app', 'Reviewed'),
            3 => \Yii::t('app', 'Ready for publication'),
            4 => \Yii::t('app', 'Published, you can answer'),
            5 => \Yii::t('app', 'Voting'),
            6 => \Yii::t('app', 'Closed'),
            7 => \Yii::t('app', 'Closed'),
            8 => \Yii::t('app', 'Rejection'),
        ];
    }

    public function getStatusClassList()
    {
        return [
            0 => 'draft_text',
            1 => 'moderation_text',
            2 => 'reviewed_text',
            3 => 'publich_text',
            4 => 'open_text',
            5 => 'voting_text',
            6 => 'closed_text',
            7 => 'closed_text',
            8 => 'rejection_text',
        ];
    }

    public function getStatusName()
    {
        $data = $this->getStatusList();

        return $data[$this->status]." : ".$this->getDate();
        
    }

    public function getStatusClassName()
    {
        $class = $this->getStatusClassList();

        return $class[$this->status];
    }

    public function getDate(){
        
        $result = "";
        if($this->isReturnDate()){
                $first_date = new \DateTime("now");
                $second_date = new \DateTime("@".$this->data);
                $interval = $second_date->diff($first_date);
                if($interval->days <= 0){
                    $result= \Yii::t('app','{h} hours',['h'=>$interval->h]);
                } else {
                    $result= \Yii::t('app', '{d} days {h} hours',['d'=>$interval->d,'h'=>$interval->h]);
                }
        }
     
        return $result;
    }

    public function getDateStatus()
    {
        
        $result = "";

        if($this->status < 6 && $this->status > 3){
            $first_date = new \DateTime("now");
            $second_date = new \DateTime("@".$this->data_status);
            
            $second_date = $second_date->modify('+1 day');

            if($second_date < $first_date){

                $questions = Questions::find()->where(['id'=>$this->id])->one();

                if($questions->status < 6 && $questions->status > 3){
                    $questions->status = $this->status + 1;
                }

               // return $questions->update(0);

            }

            $interval = $first_date->diff($second_date);

            if($interval->days <= 0){
                $result= \Yii::t('app', '{h} hours {i} minutes',['h'=>$interval->h,'i'=>$interval->i]);
            } else {
                $result= \Yii::t('app', '{h} hours {d} days',['h'=>$interval->h,'d'=>$interval->s]);
            }
        }

        return $result;
    }

    public function isReturnDate()
    {
        if($this->status <=2) return 0;
        if($this->status == 8) return 0;
        return 1;    
    }

    public function getTitle($show=0){
        return $this->title;
    }

    public function getText($show=0){
        if(!$show) return "";
        return $this->text;
    }
    public function showPrice(){
        if(isset($this->coast) && strlen($this->coast)>0) return 1;
        return 0;
    }
    public function getPrice(){
        return number_format($this->coast, 0, ' ', ' ');
    }

    public function showGrand(){
        if(isset($this->grand) && strlen($this->grand)>0) return 1;
        return 0;
    }
    public function getGrand(){
        return $this->grand;
    }

    public function statusIsClosePay(){
        if($this->status == 7) return 1;
        return 0;
    }
    public function statusIsCloseNoPay(){
        if($this->status == 6) return 1;
        return 0;
    }
    public function statusIsOpen(){
        if($this->status == 4 || $this->status == 5) return 1;
        return 0;
    }
    public function statusMoreCloseNoPay(){
        if($this->status >= 6) return 1;
        return 0;
    }

    public function statusMoreOpenBlock(){
        if($this->status >= 5) return 1;
        return 0;
    }

    public function statusNotClosePay(){
        if($this->status != 7) return 1;
        return 0;
    }

    public function statusMoreOpen(){
        if($this->status >= 4) return 1;
        return 0;
    }
    

}
