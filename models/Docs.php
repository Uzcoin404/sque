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
use PhpOffice\PhpWord\IOFactory;
class Docs extends \yii\db\ActiveRecord
{
   
    public $file="";
    public static function tableName()
    {
        return 'docs';
    }
    public function rules()
    {
        return [
            [['text','status','href','data','user'], 'required',],
            [['status'],'integer'],
            [['href'],'string'],
            ['file', 'file', 'extensions' => 'docx', 'maxSize' => 1024 * 1024 * 1 ],
        ];
    }

    public function upload($href){
        if($href!="popup_title"){
            $wordDocument = IOFactory::load($this->file->tempName);
            $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($wordDocument , 'HTML');
            $this->text= $htmlWriter->getContent();
        }
        //$htmlWriter->save('example.html');
       
    }

}
