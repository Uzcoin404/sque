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

        $price = Price::find()->where(["id" => 1])->one();

        return [
            [['title', 'text', 'cost', 'status', 'owner_id', 'grand', 'created_at', 'updated_at'], 'required',],
            [['title'], 'string'],
            [['text'], 'string'],
            // [['text_return'], 'string'],
            [['cost'], 'double', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]*\s*$/', 'min' => $price->money],
            [['status', 'owner_id'], 'integer'],
            [['grand'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => \Yii::t('app', 'Title of question'),
            'text' => \Yii::t('app', 'Text of question'),
            'cost' => \Yii::t('app', 'Cost of the best answer'),
            'status' => \Yii::t('app', 'Status of question'),
            // 'data' => \Yii::t('app', 'Data created of question'),
            'owner_id' => \Yii::t('app', 'Owner of question'),
            'grand' => \Yii::t('app', 'Country'),
            // 'data' => \Yii::t('app', 'Date update'),
            // 'text_ru' => \Yii::t('app', 'Text Russian'),
            // 'text_eng' => \Yii::t('app', 'Text English'),
            // 'text_return' => \Yii::t('app', 'Reason for return'),
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

        if ($this->status == 6) {
            return $data[$this->status] . " : " . $this->getDate();
        } elseif ($this->status == 4) {
            return Yii::t('app', 'Passed') . " : " . $this->getDate();
        } elseif ($this->status == 5) {
            return Yii::t('app', 'Passed') . " : " . $this->getDate();
        } elseif ($this->status == 1) {
            return $this->getDate();
        } elseif ($this->status == 2) {
            return $this->getDate();
        }
    }

    public function getStatusClassName()
    {
        $class = $this->getStatusClassList();

        return $class[$this->status];
    }

    public function getDate()
    {

        $result = "";
        if ($this->isReturnDate()) {
            $date_now = new \DateTime("now");
            $date_now->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));
            if ($this->status == 1) { // Создан, на модерации
                $created_date = new \DateTime("@" . $this->created_at);
                $created_date->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));
                $interval = $created_date->diff($date_now);
                $hours = $interval->d * 24 + $interval->h;
                $result = Yii::t('app', 'Moderation') . " " . Yii::t('app', 'Passed') . ": " . Yii::t('app', '{h} hours {i} minutes', ['h' => $hours, 'i' => $interval->i]);
            } elseif ($this->status == 2) { // Пропущен дальше, Модерация не пройдена, не опубликован
                $date_return_moderation = new \DateTime("@" . $this->created_at);
                $date_return_moderation->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));
                $interval = $date_return_moderation->diff($date_now);
                $hours = $interval->d * 24 + $interval->h;
                $result = Yii::t('app', 'Reviewed') . " " . Yii::t('app', 'Passed') . ": " . Yii::t('app', '{h} hours {i} minutes', ['h' => $hours, 'i' => $interval->i]);
            } elseif ($this->status == 4) {
                $date_open = new \DateTime("@" . $this->moderated_at);
                $date_open->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));
                $interval = $date_open->diff($date_now);
                $hours = $interval->d * 24 + $interval->h;
                $result = Yii::t('app', '{h} hours {i} minutes', ['h' => $hours, 'i' => $interval->i]);
            } elseif ($this->status == 5) {
                $date_voting = new \DateTime("@" . $this->voting_at);
                $date_voting->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));
                $interval = $date_voting->diff($date_now);
                $hours = $interval->d * 24 + $interval->h;
                $result = Yii::t('app', '{h} hours {i} minutes', ['h' => $hours, 'i' => $interval->i]);
            } elseif ($this->status == 6) {
                if ($this->closed_at) {
                    $closed_at = new \DateTime("@" . $this->closed_at);
                    $closed_at->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));
                    $result = $closed_at->format("d.m.Y");
                }
            } else {
                $date_open = new \DateTime("@" . $this->created_at);
                $date_open->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));
                $interval = $date_now->diff($date_now);
                $hours = $interval->d * 24 + $interval->h;
                $result = \Yii::t('app', '{h} hours {i} minutes', ['h' => $hours, 'i' => $interval->i]);
            }

            /*

                $first_date = new \DateTime("now");
                $first_date->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));
                $second_date = new \DateTime("@".$this->created_at);
                $second_date->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));
                $interval = $second_date->diff($first_date);


                if($interval->days <= 0){
 
                    $hours = $interval->d * 24 + $interval->h;
            
                    $result= \Yii::t('app', '{h} hours {i} minutes',['h'=>$hours,'i'=>$interval->i]);
                    if($this->status == 2){
                        $result = Yii::t('app','Reviewed')." ".Yii::t('app','Passed').": ".Yii::t('app', '{h} hours {i} minutes',['h'=>$interval->h,'i'=>$interval->i]);
                    } elseif($this->status == 1){
                        $result = Yii::t('app','Moderation')." ".Yii::t('app','Passed').": ".Yii::t('app', '{h} hours {i} minutes',['h'=>$interval->h,'i'=>$interval->i]);
                    }
                } else {
                    if($this->status == 6){
                        $result= date("d.m.y", $this->created_at);
                    } else {
        
                        $hours = $interval->d * 24 + $interval->h;
                        $result= \Yii::t('app', '{h} hours {i} minutes',['h'=>$hours,'i'=>$interval->i]);
                        if($this->status == 2){
                            $result = Yii::t('app','Reviewed')." ".Yii::t('app','Passed').": ".Yii::t('app', '{h} hours {i} minutes',['h'=>$hours,'i'=>$interval->i]);
                        } elseif($this->status == 1){
                            $result = Yii::t('app','Moderation')." ".Yii::t('app','Passed').": ".Yii::t('app', '{h} hours {i} minutes',['h'=>$hours,'i'=>$interval->i]);
                        }
                    }
                }*/
        }

        return $result;
    }

    public function getDateStatus()
    {

        $result = "";

        if ($this->status > 0) {
            $date_now = new \DateTime("now");
            $date_now->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));

            if ($this->status == 5) {

                $voting_at = new \DateTime("@" . $this->voting_at);
                $voting_at->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));
                $interval = $voting_at->diff($date_now);

                $hours = $interval->days * 24 + $interval->h;
                $result = Yii::t('app', 'Voting');
            } elseif ($this->status == 4) { // Открыт

                $moderated_at = new \DateTime("@" . $this->moderated_at);
                $moderated_at->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));
                $interval = $moderated_at->diff($date_now);
                $hours = $interval->days * 24 + $interval->h;
                $result = Yii::t('app', 'Open');
            } else {
                $first_date = new \DateTime("now");
                $second_date = new \DateTime("@" . $this->created_at);
                $interval = $first_date->diff($second_date);
                $hours = $interval->days * 24 + $interval->h;
                $result = "";
            }
        }

        return $result;
    }

    public function isReturnDate()
    {
        if ($this->status == 8) return 0;
        return 1;
    }

    public function getTitle($show = 0)
    {
        return $this->title;
    }

    public function getText($show = 0)
    {
        if (!$show) return "";
        return $this->text;
    }
    public function showPrice()
    {
        if (isset($this->cost) && strlen($this->cost) > 0) return 1;
        return 0;
    }
    public function getPrice()
    {
        return number_format($this->cost, 0, ' ', ' ');
    }

    public function showGrand()
    {
        if (isset($this->grand) && strlen($this->grand) > 0) return 1;
        return 0;
    }
    public function getGrand()
    {
        return "/";
    }

    public function statusIsClosePay()
    {
        if ($this->status == 7) return 1;
        return 0;
    }
    public function statusIsCloseNoPay()
    {
        if ($this->status == 6) return 1;
        return 0;
    }
    public function statusIsOpen()
    {
        if ($this->status == 4 || $this->status == 5) return 1;
        return 0;
    }
    public function statusMoreCloseNoPay()
    {
        if ($this->status >= 6) return 1;
        return 0;
    }

    public function statusMoreOpenBlock()
    {
        if ($this->status >= 5) return 1;
        return 0;
    }

    public function statusNotClosePay()
    {
        if ($this->status != 7) return 1;
        return 0;
    }

    public function statusMoreOpen()
    {
        if ($this->status >= 4) return 1;
        return 0;
    }


    public function setDateCreate()
    {
        $this->created_at = time();
        $this->updated_at = time();
    }

    public function setDateModeration()
    {
        $this->date_moderation = time();
    }

    public function setDateUpdate()
    {
        $this->date_update = time();
    }

    public function setDateReturnModeration()
    {
        $this->date_return_moderation = time();
    }

    public function setDateOpen()
    {
        $this->updated_at = time();
    }
    public function setDateEndOpen($not_now = 0)
    {
        if (!$not_now) {
            $this->date_end_open = strtotime("+1 day");
        } else {
            $this->date_end_open = $not_now + (24 * 60 * 60);;
        }
    }

    public function setDateVoting()
    {
        $this->date_voting = time();
    }
    public function setDateEndVoting($not_now = 0)
    {
        if (!$not_now) {
            $this->date_end_voting = strtotime("+1 day");
        } else {

            $this->date_end_voting = $not_now + (24 * 60 * 60);
        }
    }
    public function setDateClose()
    {
        $this->closed_at = time();
    }


    public function WasOpened($id = 0)
    {
        $question = 0;
        if ($id) {
            $question = Questions::find()->where(['id' => $id])->one();
        } else {
            $question = $this;
        }
        if (!isset($question->id)) return 0;

        //$closed_at = new \DateTime("@".$question->closed_at);
        // $closed_at->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));

        $date_end_open = new \DateTime("@" . $question->date_end_open);
        $date_end_open->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));
        $date_open = new \DateTime("@" . $question->date_open);
        $date_open->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));
        $interval = $date_end_open->diff($date_open);
        //$interval = $closed_at->diff($date_open);
        $hours = $interval->d * 24 + $interval->h;

        return \Yii::t('app', '{h} hours {i} minutes', ['h' => $hours, 'i' => $interval->i]);
    }

    public function WasVoting($id = 0)
    {
        $question = 0;
        if ($id) {
            $question = Questions::find()->where(['id' => $id])->one();
        } else {
            $question = $this;
        }
        if (!isset($question->id)) return 0;

        $date_end_voting = new \DateTime("@" . $question->date_end_voting);
        $date_end_voting->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));
        $date_voting = new \DateTime("@" . $question->date_voting);
        $date_voting->setTimezone(new \DateTimeZone('Asia/Yekaterinburg'));
        $interval = $date_end_voting->diff($date_voting);
        $hours = $interval->d * 24 + $interval->h;
        return \Yii::t('app', '{h} hours {i} minutes', ['h' => $hours, 'i' => $interval->i]);
    }
}
