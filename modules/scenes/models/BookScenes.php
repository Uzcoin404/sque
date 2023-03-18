<?php

namespace app\modules\scenes\models;
use app\modules\books\models\Books;
use app\modules\text\models\BookText;
use yii\helpers\ArrayHelper;
use Yii;
use app\modules\scenes\models\BookScenesGroup;
/**
 * This is the model class for table "book_scene".
 *
 * @property int $id
 * @property int $book_id
 * @property string $name
 * @property int|null $chapter_id
 * @property string|null $plan
 */
class BookScenes extends \yii\db\ActiveRecord
{
    public $group;
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_scene';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_book', 'name'], 'required','message'=>'Поле "{attribute}" не может быть пустым'],
            [['id_book','status'], 'integer'],
            [['plan'], 'string'],
            [['name'], 'string', 'max' => 60],
            [['id_book'], 'exist', 'skipOnError' => true, 'targetClass' => Books::className(), 'targetAttribute' => ['id_book' => 'id']],
            [['image'], 'string', 'max' => 255],
            [['scene_data'], 'string', 'max' => 45],
            [['scene_weather'], 'string', 'max' => 255],
            [['group'], 'validateGroup'],
            [['id_group'],'string'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg','wrongExtension'=>"Выбран не верный формат"],
        ];
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
            'id_book' => 'Книга',
            'name' => 'Название сцены',
            'chapter_id' => 'Глава',
            'plan' => 'План сцены',
            'imageFile'=>'Изображение',
            'group'=>'Группа',
            "status"=>"Статус",
            "scene_weather"=>"Погода",
            "scene_data"=>"Дата",
        ];
    }

    public function upload()
    {
    //    if ($this->validate()) {
            $user=Yii::$app->user->identity;
            //if(!isset($this->imageFile->baseName)) return 0;
            $name=MD5($user->id."".strtotime('now')."".$this->imageFile->baseName) . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs(Yii::getAlias('@webroot').'/img/scenes/' .$name) ;
            return $name;
      //  } else {
     //       return false;
     //   }
    }

    public function getBooks()
    { 
        $user=Yii::$app->user->identity;
        $groups = Books::find()->where(["id_user"=>$user->id])->all();
        
        return ArrayHelper::map($groups,'id','name');

    }
    public function getBook()
    {
        return $this->hasOne(Books::className(), ['id' => 'id_book']);
    }

    public function getGroupsList()
    { 
        $user=Yii::$app->user->identity;
       // $book_id=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
        $groups = BookScenesGroup::find()->where(["id_user"=>$user->id,'status'=>1,'id_book'=>$this->id_book])->all();
        $result=ArrayHelper::map($groups,'id','name');
        //$result[0]="-";
        return $result;

    }
    public function findGroup(){
        $user=Yii::$app->user->identity;
        if(!$this->group ||  (is_countable($this->group) && count($this->group)<=0)){
            //$book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
            $BookPersGroup=BookScenesGroup::find()->where(['id_book'=>$this->id_book,'isDefault'=>1])->one();
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
                        $color = array_rand(BookScenesGroup::getColorList(), 1);
                        $BookGroups = new BookScenesGroup();
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
                $group_res = BookScenesGroup::find()->where(["id"=>$group])->one();
                if(isset($group_res->name)){
                    $result.="<span style='background-color:".$group_res->color."'>".$group_res->name."</span> / ";
                }
            }
        return $result;
    }
    
    public function getGroupColor(){
        if(!isset($this->id_group))
        return "transparent";
        $group = BookScenesGroup::find()->where(["id"=>$this->id_group])->one();
        if(!isset($group->color))
        return "transparent";
        return $group->color;
    }

    public function getStatus(){
        return[
            '1' => 'Доступна',
            '0' => 'Отключена',
        ];
    }

    public function getPopover($text=false){
   
        $count=0;
        $result=BookText::find()->where(["id_scenes"=>$this->id])->orderBy("date DESC")->one();
        if(isset($result->id)){
            $count=$result->length;
        }
        if($text){
            return "План сцены<br>".mb_substr(strip_tags($this->plan),0,150)."<br>Дата:<br>".$this->scene_data."<br>Погода:<br>".$this->scene_weather."<br>Написано слов:<br>".$count."<br>";
        }
        return "<dl><dt>План сцены:</dt><dd>".mb_substr(strip_tags($this->plan),0,150)."</dd><dt>Дата:</dt><dd>".$this->scene_data."</dd><dt>Погода:</dt><dd>".$this->scene_weather."</dd><dt>Написано слов:</dt><dd>".$count."</dd></dl>";
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
        return BookScenes::find()->where(['id_book'=>$book_id])->max('sort')+1;
    }

    public function getGroup($group_id){
        return BookScenesGroup::find()->where(["id"=>$group_id])->one();
    }
}
