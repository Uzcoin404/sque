<?php

namespace app\modules\books\models;
use app\modules\books\models\BookGroups;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property int $status
 * @property int $id_user
 * @property int $date_create
 * @property int $date_chenge
 */
class Books extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $group;
    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status', 'id_user', 'date_chenge'], 'required','message'=>'Поле "{attribute}" не может быть пустым'],
            [['status', 'id_user', 'date_chenge','plan_words','main'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['image'], 'string', 'max' => 255],
            [['genre'], 'string', 'max' => 255],
            [['mainpers'], 'string', 'max' => 255],
            [ ['plan_words'], 'number', 'max' => 999999999, 'min'=>1],
            [['situation'], 'string'],
            [['target'], 'string'],
            [['annotation'], 'string'],
            [['conflict'], 'string'],
            [['crisis'], 'string'],
            [['ex_synopsis'], 'string'],
            [['plan'], 'string'],
            [['idea'], 'string'],
            [['group'], 'validateGroup'],
            [['id_group'],'string'],
            [['date_end'], 'validatedateend'],
            [['date_create'], 'validatedate'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg','wrongExtension'=>"Выбран не верный формат",],
        ];
    }
    public function validateGroup($attribute, $params)
    {
        
        if ($this->$attribute<=0) {
            $this->addError($attribute, 'Не верно указана группа');
        }
    }
   
    public function validatedate($attribute, $params)
    {
        //$this->addError($attribute, strtotime("10 year"));
        if(!is_int($this->$attribute))
        if(strtotime($this->$attribute)<=strtotime("-10 year")){
            $this->addError($attribute, 'Не верно указана дата');
        }
        if ($this->$attribute<=0) {
            $this->addError($attribute, 'Не верно указана дата');
        }
    }

    public function validatedateend($attribute, $params)
    {
        
        if(!is_int($this->$attribute))
        if(strtotime($this->$attribute)>=strtotime("+10 year")){
            $this->addError($attribute, 'Не верно указана дата');
        }
        if ($this->$attribute<=0) {
            $this->addError($attribute, 'Не верно указана дата завершения');
        }
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'image' => 'Image',
            'imageFile' => 'Обложка',
            'status' => 'Статус',
            'id_user' => 'Id User',
            'genre'=>'Жанр',
            'mainpers'=>'Персонаж',
            'date_chenge' => 'Date Chenge',
            'group' => 'Группа',
            "annotation"=>"Краткий синопсис",
            "plan"=>"Идея",
            "idea"=>"Расширенный премис",
            "situation"=>"Ситуация",
            "target"=>"Цель",
            "conflict"=>"Конфликт",
            "crisis"=>"Кризис",
            "ex_synopsis"=>"Расширенный синопсис",
            "main"=>"Активная книга",
            'date_end'=>'Планируемая дата завершения',
            'plan_words'=>'Планируемое количество слов',
            "date_create"=>"Дата начала работы над книгой"
        ];
    }

    public function upload()
    {
      //  if ($this->validate()) {
            $user=Yii::$app->user->identity;
            //if(!isset($this->imageFile->baseName)) return 0;
            $name=MD5($user->id."".strtotime('now')."".$this->imageFile->baseName) . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs(Yii::getAlias('@webroot').'/img/books/' .$name) ;
            return $name;
       // } else {
      //      return false;
       // }
    }

    public function getBookGroupsList()
    { 
        $user=Yii::$app->user->identity;
        $groups = BookGroups::find()->where(["id_user"=>$user->id])->all();
        
        return ArrayHelper::map($groups,'id','name');

    }

    public function getGroupName(){
        $result="";
        if(!isset($this->id_group))
        return $result;
            foreach($this->id_group as $group){
                $group_res = BookGroups::find()->where(["id"=>$group])->one();
                if(isset($group_res->name)){
                    $result.="<span style='background-color:".$group_res->color."'>".$group_res->name."</span> / ";
                }
            }
        return $result;
    }
    
    public function getGroupColor(){
        if(!isset($this->id_group))
        return "transparent";
        $group = BookGroups::find()->where(["id"=>$this->id_group])->one();
        if(!isset($group->color))
        return "transparent";
        return $group->color;
    }

    public function findGroup(){
        $user=Yii::$app->user->identity; 
        if(!$this->group || (is_countable($this->group) && count($this->group)<=0)){
            $BookPersGroup=BookGroups::find()->where(['id_user'=>$user->id,'isDefault'=>1])->one();
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
                        $color = array_rand(BookGroups::getColorList(), 1);
                        $BookGroups = new BookGroups();
                        $BookGroups->name=$group;
                        $BookGroups->id_user=$user->id;
                        $BookGroups->color= $color;
                        if($BookGroups->name=="TyTyTyHGTYbggJJgtUHBg"){
                            $BookGroups->name="Без группы";
                            $BookGroups->isDefault=1;
                        }
                        $BookGroups->save();
                        $result= $result.$BookGroups->id."|";
                    }
                }
            }
        }
       
        return $result;
    }

    public function getStatus(){
        return[
            '1' => 'Доступна',
            '0' => 'Отключена',
        ];
    }
    public function getGroupsList()
    { 
        $user=Yii::$app->user->identity;
  
            $groups = BookGroups::find()->where(["id_user"=>$user->id,'status'=>1])->all();
            $result=ArrayHelper::map($groups,'id','name');
        
       // $result[0]="-";
        return $result;

    }

    public function getPopover($text=false){
        if($text){
            return "Жанр:<br>".mb_substr(strip_tags($this->genre),0,50)."<br>Краткий синопсис:<br>".mb_substr(strip_tags($this->annotation),0,150)."<br>";
        }
        return "<dl><dt>Жанр:</dt><dd>".mb_substr(strip_tags($this->genre),0,50)."</dd><dt>Краткий синопсис:</dt><dd>".mb_substr(strip_tags($this->annotation),0,150)."</dd></dl>";
    }
    public function afterFind(){
        parent::afterFind();
        $this->name=strip_tags($this->name);
        $this->group=$this->id_group;
        $this->id_group=explode('|',$this->id_group);
    }

    public function getMaxSort(){
        $user=Yii::$app->user->identity;
        return Books::find()->where(["id_user"=>$user->id])->max('sort')+1;
    }

    public function getGroup($group_id){
        return BookGroups::find()->where(["id"=>$group_id])->one();
    }

}
