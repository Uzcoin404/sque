<?php

namespace app\modules\items\models;
use app\modules\books\models\Books;
use yii\helpers\ArrayHelper;
use Yii;
use app\modules\items\models\BookItemsGroup;
/**
 * This is the model class for table "book_items".
 *
 * @property int $id
 * @property int $id_book
 * @property string $name
 * @property string $description
 *
 * @property Books $book
 */
class BookItems extends \yii\db\ActiveRecord
{
    public $group;
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_book', 'name'], 'required','message'=>'Поле "{attribute}" не может быть пустым'],
            [['id_book','status'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['id_book'], 'exist', 'skipOnError' => true, 'targetClass' => Books::className(), 'targetAttribute' => ['id_book' => 'id']],
            [['image'], 'string', 'max' => 255],
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
            'name' => 'Название предмета',
            'description' => 'Описание',
            'group' => 'Группа',
            'status' => 'Вкл./Выкл.',
            'imageFile'=>"Изображение"
        ];
    }

    public function upload()
    {
     
            $user=Yii::$app->user->identity;
            if(!isset($this->imageFile)) return "";
            $name=MD5($user->id."".strtotime('now')."".$this->imageFile->baseName) . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs(Yii::getAlias('@webroot').'/img/items/' .$name) ;
            $this->imageFile="";
            return $name;

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

    public function getBooks()
    { 
        $user=Yii::$app->user->identity;
        $groups = Books::find()->where(["id_user"=>$user->id])->all();
        
        return ArrayHelper::map($groups,'id','name');

    }

    
    public function getGroupsList()
    { 
        $user=Yii::$app->user->identity;
        //$book_id=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
        $groups = BookItemsGroup::find()->where(["id_user"=>$user->id,'status'=>1,'id_book'=> $this->id_book])->all();
        $result=ArrayHelper::map($groups,'id','name');
        //$result[0]="-";
        return $result;

    }
    public function findGroup(){
        $user=Yii::$app->user->identity;
        
        if(!$this->group || (is_countable($this->group) && count($this->group)<=0)){
            //$book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
            $BookPersGroup=BookItemsGroup::find()->where(['id_book'=>$this->id_book,'isDefault'=>1])->one();
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
                        $color = array_rand(BookItemsGroup::getColorList(), 1);
                        $BookGroups = new BookItemsGroup();
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
                $group_res = BookItemsGroup::find()->where(["id"=>$group])->one();
                if(isset($group_res->name)){
                    $result.="<span style='background-color:".$group_res->color."'>".$group_res->name."</span> / ";
                }
            }
     
        return $result;
    }
    
    public function getGroupColor(){
        if(!isset($this->id_group))
        return "transparent";
        $group = BookItemsGroup::find()->where(["id"=>$this->id_group])->one();
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
        if($text){
            return "Описание:<br>".mb_substr(strip_tags($this->description),0,150)."<br>";
        }
        return "<dl><dt>Описание:</dt><dd>".mb_substr(strip_tags($this->description),0,150)."</dd></dl>";
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
        return BookItems::find()->where(['id_book'=>$book_id])->max('sort')+1;
    }
    public function getGroup($group_id){
        return BookItemsGroup::find()->where(["id"=>$group_id])->one();
    }
}
