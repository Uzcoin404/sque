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
use app\models\Price;

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
        
        $price = Price::find()->where(["id"=>1])->one();

        return [
            [['title','text','coast','status','data','owner_id','grand','data_status','data_start'], 'required',],
            [['title'],'string'],
            [['text'],'string'],
            [['text_return'],'string'],
            [['coast'], 'double', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]*\s*$/', 'min'=>$price->money],
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
            'data'=> \Yii::t('app','Date update'),
            'text_return'=> \Yii::t('app','Reason for return'),
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

        if($this->status == 6){
            return $data[$this->status]." : ".$this->getDate();
        } elseif($this->status == 4) {
            return Yii::t('app','Passed')." : ".$this->getDate();
        } elseif($this->status == 5){
            return Yii::t('app','Passed')." : ".$this->getDate();
        } elseif($this->status == 1){
            return $this->getDate();
        } elseif($this->status == 2){
            return $this->getDate();
        }

        
        
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
                $second_date = new \DateTime("@".$this->data_status);
                $interval = $second_date->diff($first_date);
                if($interval->days <= 0){
                    $result= \Yii::t('app','{h} hours',['h'=>$interval->h]);
                    if($this->status == 2){
                        $result = Yii::t('app','Reviewed')." ".Yii::t('app','Passed').": ".Yii::t('app', '{h} hours {i} minutes',['h'=>$interval->h,'i'=>$interval->i]);
                    } elseif($this->status == 1){
                        $result = Yii::t('app','Moderation')." ".Yii::t('app','Passed').": ".Yii::t('app', '{h} hours {i} minutes',['h'=>$interval->h,'i'=>$interval->i]);
                    }
                } else {
                    if($this->status == 6){
                        $result= date("d.m.y", $this->data_status);
                    } else {
                        $hours = $interval->d * 24 + $interval->h;
                        $result= \Yii::t('app', '{h} hours {i} minutes',['h'=>$hours,'i'=>$interval->i]);
                        if($this->status == 2){
                            $result = Yii::t('app','Reviewed')." ".Yii::t('app','Passed').": ".Yii::t('app', '{h} hours {i} minutes',['h'=>$hours,'i'=>$interval->i]);
                        } elseif($this->status == 1){
                            $result = Yii::t('app','Moderation')." ".Yii::t('app','Passed').": ".Yii::t('app', '{h} hours {i} minutes',['h'=>$hours,'i'=>$interval->i]);
                        }
                    }
                }
        }
     
        return $result;
    }

    public function getDateStatus()
    {
        
        $result = "";

        if($this->status > 0){
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
                $result= \Yii::t('app', 'Remained {h} hours {i} minutes',['h'=>$interval->h,'i'=>$interval->i]);
                if($this->status == 4) {
                    $result = Yii::t('app','Open')." ".Yii::t('app', 'Remained {h} hours {i} minutes',['h'=>$interval->h,'i'=>$interval->i]);
                } elseif($this->status == 5){
                    $result = Yii::t('app','Voting')." ".Yii::t('app', 'Remained {h} hours {i} minutes',['h'=>$interval->h,'i'=>$interval->i]);
                }
            } else {
                $hours = $interval->d * 24 + $interval->h;
                $result= \Yii::t('app', 'Remained {h} hours {i} minutes',['h'=>$hours,'i'=>$interval->i]);
                if($this->status == 4) {
                    $result = Yii::t('app','Open')." ".Yii::t('app', 'Remained {h} hours {i} minutes',['h'=>$hours,'i'=>$interval->i]);
                } elseif($this->status == 5){
                    $result = Yii::t('app','Voting')." ".Yii::t('app', 'Remained {h} hours {i} minutes',['h'=>$hours,'i'=>$interval->i]);
                }
            }
        }

        return $result;
    }

    public function isReturnDate()
    {
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
