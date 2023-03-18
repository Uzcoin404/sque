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
class Notes extends \yii\db\ActiveRecord
{
    public $group;
    public $id_scenes;
    public static function tableName()
    {
        return 'notes';
    }
    public function rules()
    {
        return [
            [['id_book','type','id_target','sort'], 'required','message'=>'Поле "{attribute}" не может быть пустым'],
            [['name'], 'validateContent'],
            [['text'], 'validateContent'],
            [['id_book','type','id_target','sort'], 'integer'],
            [['name'], 'string', 'max' => 40],
            [['text'], 'string'],
            [['group'], 'validateGroup'],
            [['favorite'], 'integer'],
            [['id_group'],'string'],
        ];
    }
    public function validateContent($attribute, $params)
    {

        $title=strip_tags($this->name);
        $content=strip_tags($this->text);
        $is_image=0;
        if (strpos($this->text, '<img') !== false) {
            $is_image=1;
        }
        if ((strlen($title)<=0 && strlen($content)<=0) || ( strlen($title)<=0 && !$is_image)) {
            $this->addError($attribute, 'Вам необходимо указать название или содержимое заметки');
        }
    }

    public function validateGroup($attribute, $params)
    {
        if ($this->$attribute<=0) {
            $this->addError($attribute, 'Не верно указана группа');
        }
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название заметки',
            'image' => 'Image',
            'imageFile' => 'Обложка',
            'status' => 'Статус',
            'id_user' => 'Id User',
            'genre'=>'Жанр',
            'mainpers'=>'',
            'date_create' => 'Date Create',
            'date_chenge' => 'Date Chenge',
            'group' => 'Группа',
            'id_scenes'=>'Общие заметки',
        ];
    }

    public function getTypeName(){
        if($this->type==2){
            return "Сцены";
        }elseif($this->type==3){
            return "Персонажи";

        }elseif($this->type==4){
            return "Локации";

        }elseif($this->type==5){
            return "Предметы";

        }elseif($this->type==1){
            return "Общие";

        }
    }

    public function getGroupType(){
        if($this->type==2){
            return "#00aba922";
        }elseif($this->type==3){
            return "#0050ef22";

        }elseif($this->type==4){
            return "#aa00ff22";

        }elseif($this->type==5){
            return "#d8007322";

        }elseif($this->type==1){
            return "#d8007322";

        }
    }

    public function getPopover($text=false){
        return mb_substr($this->text, 0, 300);
    }

    public function getGroupsList()
    { 
        $user=Yii::$app->user->identity;
        $book_id=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one();
        if(isset($book_id->id)){
            $book_id=$book_id->id;
            $groups = NoteGroups::find()->where(["id_user"=>$user->id,'status'=>1,'id_book'=> $book_id])->all();
            $result=ArrayHelper::map($groups,'id','name');
        }
        //$result[0]="-";
        return $result;

    }

    public function findGroup(){
        $user=Yii::$app->user->identity;
        if(!$this->group ||  (is_countable($this->group) && count($this->group)<=0)){
            $book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
            $BookPersGroup=NoteGroups::find()->where(['id_book'=>$book,'isDefault'=>1])->one();
            return $BookPersGroup->id."|";
        }
        $result="";
        if(is_array($this->group)){
            foreach($this->group as $group){
                if(intval($group)>0){
                    $result= $result.$group."|";
                }else{
                    $char=mb_substr($group, 0, 1);
                    $group = mb_substr( $group, 1);
                    if($group!="-" && $group!="0" && $char=="@"){
                        $color = array_rand(NoteGroups::getColorList(), 1);
                        $BookGroups = new NoteGroups();
                        $BookGroups->name=$group;
                        $BookGroups->id_user=$user->id;
                        $BookGroups->color= $color;
                        $BookGroups->id_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
                        $BookGroups->status=1;
                        $BookGroups->save();
                        $result= $result.$BookGroups->id."|";
                    }
                }
            }
        }
       
        return $result;
    }

    public function getGroupName(){

        $result="";
        if(!isset($this->id_group))
        return $result;
            foreach($this->id_group as $group){
                $group_res = NoteGroups::find()->where(["id"=>$group])->one();
                if(isset($group_res->name)){
                    $result.="<span style='background-color:".$group_res->color."'>".$group_res->name."</span> / ";
                }
            }
        return $result;
    }
    
    public function getGroupColor(){
        if(!isset($this->id_group))
        return "transparent";
        $group = NoteGroups::find()->where(["id"=>$this->id_group])->one();
        if(!isset($group->color))
        return "transparent";
        return $group->color;
    }

    public function afterFind(){
        parent::afterFind();
        $this->name=strip_tags($this->name);
        $this->group=$this->id_group;
        $this->id_group=explode('|',$this->id_group);
    }

    public function getMaxSort(){
        $user=Yii::$app->user->identity;
        $book_id=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
        return Notes::find()->where(['id_book'=>$book_id])->max('sort')+1;
    }

    public function getAllType($type){
        $user = Yii::$app->user->identity;
        $book_id=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
        $notes=Notes::find()->where(['AND',['OR',["id_book"=>$book_id],["id_book"=>0]],['status'=>1],["id_user"=>$user->id],["type"=>$type]])->orderBy(["type"=>SORT_ASC,"id_group"=>SORT_ASC,"sort"=>SORT_ASC])->all();
        $result=[];
        foreach($notes as $note){
            if(strlen($note->name)>0){
                $result[$note->id]=$note->name;
            }else{
                $result[$note->id]=mb_substr(html_entity_decode(strip_tags($note->text)), 0, 50);
            }
            
        }
        return $result;
    }

    public function getGroup($group_id){
        return NoteGroups::find()->where(["id"=>$group_id])->one();
    }

}
/*
1- Книга
2 - Сцены
3 - Персонажи
4 - Локации
5 - Предметы

*/