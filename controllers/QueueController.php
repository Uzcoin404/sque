<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\Queue;
use app\models\User;
use app\modules\books\models\Books;
use app\modules\items\models\BookItems;
use app\modules\locations\models\BookLocations;
use app\modules\pers\models\BookPers;
use app\modules\scenes\models\BookScenes;
// AJAX
use yii\widgets\ActiveForm;
class QueueController extends Controller
{
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [

                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            
        ];
    }

   
    //Главный экран
    public function actionIndex()
    {
       $Queues=Queue::find()->where(["status"=>1])->one();
        if(!isset($Queues->id)) return 0;
       if($Queues->type=="USER_DOWNLOAD"){
            if($this->USER_DOWNLOAD($Queues->id_model)){
                $task=new Queue();
                $task->id_model=$Queues->id_model;
                $task->type="USER_BOOKS_DOWLOAS";
                $task->value=MD5($Queues->id_model);
                $task->status=1;
                if($task->save()){
                    $Queues->status=0;
                    $Queues->save();
                }
            }
       }

       if($Queues->type=="USER_BOOKS_DOWLOAS"){
            if($this->USER_BOOKS_DOWLOAS($Queues->id_model,$Queues->value)){
                $Queues->status=0;
                $Queues->save();
            }
        }

        if($Queues->type=="USER_ITEMS_DOWLOAS"){
            if($this->USER_ITEMS_DOWLOAS($Queues->id_model,$Queues->value)){
                $Queues->status=0;
                $Queues->save();
            }
        }

        if($Queues->type=="USER_LOCATIONS_DOWLOAS"){
            if($this->USER_LOCATIONS_DOWLOAS($Queues->id_model,$Queues->value)){
                $Queues->status=0;
                $Queues->save();
            }
        }

        if($Queues->type=="USER_PERS_DOWLOAS"){
            if($this->USER_PERS_DOWLOAS($Queues->id_model,$Queues->value)){
                $Queues->status=0;
                $Queues->save();
            }
        }

        if($Queues->type=="USER_SCENES_DOWLOAS"){
            if($this->USER_SCENES_DOWLOAS($Queues->id_model,$Queues->value)){
                $Queues->status=0;
                $Queues->save();
            }
        }
        if($Queues->type=="USER_DOWNLOAD_ARHIVE"){
            if($this->USER_DOWNLOAD_ARHIVE($Queues->id_model,$Queues->value)){
                $Queues->status=0;
                $Queues->save();
            }
        }
        if($Queues->type=="USER_DOWNLOAD_EMAIL"){
            if($this->USER_DOWNLOAD_EMAIL($Queues->id_model,$Queues->value)){
                $Queues->status=0;
                $Queues->save();
            }
        }
    }

    private function USER_DOWNLOAD_EMAIL($user_id,$value){
        $user=User::findOne($user_id);
        if(isset($user->id)){
            return $this->sendEmail(
                $user->email,
                "Архив готов",
                "Ваш архив готов, скачать вы можете его по ссылке: <a href='https://service.my-novel.online/profile/".$value.".zip'>https://service.my-novel.online/profile/".$value.".zip</a>"
            );
        
        }
        return 0;
    }

    private function USER_DOWNLOAD_ARHIVE($user_id,$value){
        $dir=Yii::getAlias('@webroot').'/profile/' .$value;
        if(File_exists(Yii::getAlias('@webroot').'/profile/'.$value.'.zip')){
            unlink(Yii::getAlias('@webroot').'/profile/'.$value.'.zip');
        }
        
        if($this->zip($dir, Yii::getAlias('@webroot').'/profile/'.$value.'.zip')){
            $this->rmRec($dir);
            $task=new Queue();
            $task->id_model=$user_id;
            $task->type="USER_DOWNLOAD_EMAIL";
            $task->value=$value;
            $task->status=1;
            if($task->save()){
                return 1;
            }
            
        }
        return 0;
    }

    

    private function USER_SCENES_DOWLOAS($id_book,$value){
        $models=BookScenes::find()->where(["id_book"=>$id_book,'status'=>1])->all();
        foreach($models as $model){
            $dir=Yii::getAlias('@webroot').'/profile/' .$value."/Сцены";
            $this->rmRec($dir);
            mkdir($dir);

            //Копируем изображение если оно есть
            if(isset($model->image) && strlen($model->image)>1){
                $img_path=Yii::getAlias('@webroot').'/img/scenes/' .$model->image;
                $new_img_path=$dir."/".$model->image;
                copy($img_path, $new_img_path);
            }

            //Копируем содержимое модели в текстовый документ и сохраняем его в папку
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $section = $phpWord->addSection();
            foreach($model->attributes as $key=>$val){
                if($this->attradd($key)){

                        $section->addText(
                            $model->attributeLabels()[$key].": ".$val,
                            array('name' => 'Tahoma', 'size' => 10)
                        );
                
                }
            }
            $phpWord->save($dir.'/'.$model->name.'.docx');
           
        }
        return 1;
    }

    private function USER_PERS_DOWLOAS($id_book,$value){
        $models=BookPers::find()->where(["id_book"=>$id_book,'status'=>1])->all();
        foreach($models as $model){
            $dir=Yii::getAlias('@webroot').'/profile/' .$value."/Персонажи";
            $this->rmRec($dir);
            mkdir($dir);

            //Копируем изображение если оно есть
            if(isset($model->image) && strlen($model->image)>1){
                $img_path=Yii::getAlias('@webroot').'/img/pers/' .$model->image;
                $new_img_path=$dir."/".$model->image;
                copy($img_path, $new_img_path);
            }

            //Копируем содержимое модели в текстовый документ и сохраняем его в папку
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $section = $phpWord->addSection();
            foreach($model->attributes as $key=>$val){
                if($this->attradd($key)){

                        $section->addText(
                            $model->attributeLabels()[$key].": ".$val,
                            array('name' => 'Tahoma', 'size' => 10)
                        );
                
                }
            }
            $phpWord->save($dir.'/'.$model->nickname.'.docx');
           
        }
        return 1;
    }

    private function USER_LOCATIONS_DOWLOAS($id_book,$value){
        $models=BookLocations::find()->where(["id_book"=>$id_book,'status'=>1])->all();
        foreach($models as $model){
            $dir=Yii::getAlias('@webroot').'/profile/' .$value."/Локации";
            $this->rmRec($dir);
            mkdir($dir);

            //Копируем изображение если оно есть
            if(isset($model->image) && strlen($model->image)>1){
                $img_path=Yii::getAlias('@webroot').'/img/locations/' .$model->image;
                $new_img_path=$dir."/".$model->image;
                copy($img_path, $new_img_path);
            }

            //Копируем содержимое модели в текстовый документ и сохраняем его в папку
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $section = $phpWord->addSection();
            foreach($model->attributes as $key=>$val){
                if($this->attradd($key)){

                        $section->addText(
                            $model->attributeLabels()[$key].": ".$val,
                            array('name' => 'Tahoma', 'size' => 10)
                        );
                
                }
            }
            $phpWord->save($dir.'/'.$model->name.'.docx');
           
        }
        return 1;
    }

    private function USER_ITEMS_DOWLOAS($id_book,$value){
        $models=BookItems::find()->where(["id_book"=>$id_book,'status'=>1])->all();
        foreach($models as $model){
            $dir=Yii::getAlias('@webroot').'/profile/' .$value."/Предметы";
            $this->rmRec($dir);
            mkdir($dir);

            //Копируем изображение если оно есть
            if(isset($model->image) && strlen($model->image)>1){
                $img_path=Yii::getAlias('@webroot').'/img/items/' .$model->image;
                $new_img_path=$dir."/".$model->image;
                copy($img_path, $new_img_path);
            }

            //Копируем содержимое модели в текстовый документ и сохраняем его в папку
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $section = $phpWord->addSection();
            foreach($model->attributes as $key=>$val){
                if($this->attradd($key)){

                        $section->addText(
                            $model->attributeLabels()[$key].": ".$val,
                            array('name' => 'Tahoma', 'size' => 10)
                        );
                
                }
            }
            $phpWord->save($dir.'/'.$model->name.'.docx');
           
        }
        return 1;
    }

    private function USER_BOOKS_DOWLOAS($user_id,$value){
        $models=Books::find()->where(["id_user"=>$user_id,'status'=>1])->all();
        foreach($models as $model){
            $dir=Yii::getAlias('@webroot').'/profile/' .$value."/".$model->name;
            $this->rmRec($dir);
            mkdir($dir);

            //Копируем изображение если оно есть
            if(isset($model->image) && strlen($model->image)>1){
                $img_path=Yii::getAlias('@webroot').'/img/books/' .$model->image;
                $new_img_path=$dir."/".$model->image;
                copy($img_path, $new_img_path);
            }

            //Копируем содержимое модели в текстовый документ и сохраняем его в папку
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $section = $phpWord->addSection();
            foreach($model->attributes as $key=>$val){
                if($this->attradd($key)){

                        $section->addText(
                            $model->attributeLabels()[$key].": ".$val,
                            array('name' => 'Tahoma', 'size' => 10)
                        );
                
                }
            }
            $phpWord->save($dir.'/'.$model->name.'.docx');
            //Ставим в очередь выгрузку предметов
            $task=new Queue();
            $task->id_model=$model->id;
            $task->type="USER_ITEMS_DOWLOAS";
            $task->value=$value."/".$model->name;
            $task->status=1;
            $task->save();

            $task=new Queue();
            $task->id_model=$model->id;
            $task->type="USER_LOCATIONS_DOWLOAS";
            $task->value=$value."/".$model->name;
            $task->status=1;
            $task->save();

            $task=new Queue();
            $task->id_model=$model->id;
            $task->type="USER_PERS_DOWLOAS";
            $task->value=$value."/".$model->name;
            $task->status=1;
            $task->save();

            $task=new Queue();
            $task->id_model=$model->id;
            $task->type="USER_SCENES_DOWLOAS";
            $task->value=$value."/".$model->name;
            $task->status=1;
            $task->save();
        }

        $task=new Queue();
        $task->id_model=$user_id;
        $task->type="USER_DOWNLOAD_ARHIVE";
        $task->value=$value;
        $task->status=1;
        $task->save();

        return 1;
    }
    

    private function USER_DOWNLOAD($id){
        $User=User::findOne($id);
        $dir_name=MD5($User->id);
        $user_dir=Yii::getAlias('@webroot').'/profile/' .$dir_name;
        $this->rmRec($user_dir);
        mkdir($user_dir);
        return 1;
    }

    

    private function attradd($attr){
        if($attr!="id" && $attr!="id_user" && $attr!="status" && $attr!="image" && $attr!="id_group" && $attr!="sort" && $attr!="id_chapter"){
            return 1;
        }
        return 0;
    }

    private function rmRec($path) {
        if (is_file($path)) return unlink($path);
        if (is_dir($path)) {
          foreach(scandir($path) as $p) if (($p!='.') && ($p!='..'))
            $this->rmRec($path.DIRECTORY_SEPARATOR.$p);
          return rmdir($path);
          }
        return false;
        }
        private static function zip($source, $destination)
        {
            if (!extension_loaded('zip') || !file_exists($source)) {
                return false;
            }
        
            $zip = new  \ZipArchive();
            if (!$zip->open($destination, \ZIPARCHIVE::CREATE)) {
                return false;
            }
        
            $source = str_replace('\\', DIRECTORY_SEPARATOR, realpath($source));
            $source = str_replace('/', DIRECTORY_SEPARATOR, $source);
        
            if (is_dir($source) === true) {
                $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source),
                    \RecursiveIteratorIterator::SELF_FIRST);
        
                foreach ($files as $file) {
                    $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
                    $file = str_replace('/', DIRECTORY_SEPARATOR, $file);
        
                    if ($file == '.' || $file == '..' || empty($file) || $file == DIRECTORY_SEPARATOR) {
                        continue;
                    }
                    // Ignore "." and ".." folders
                    if (in_array(substr($file, strrpos($file, DIRECTORY_SEPARATOR) + 1), array('.', '..'))) {
                        continue;
                    }
        
                    $file = realpath($file);
                    $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
                    $file = str_replace('/', DIRECTORY_SEPARATOR, $file);
        
                    if (is_dir($file) === true) {
                        $d = str_replace($source . DIRECTORY_SEPARATOR, '', $file);
                        if (empty($d)) {
                            continue;
                        }
                        $zip->addEmptyDir($d);
                    } elseif (is_file($file) === true) {
                        $zip->addFromString(str_replace($source . DIRECTORY_SEPARATOR, '', $file),
                            file_get_contents($file));
                    } else {
                        // do nothing
                    }
                }
            } elseif (is_file($source) === true) {
                $zip->addFromString(basename($source), file_get_contents($source));
            }
        
            return $zip->close();
        }


        private function sendEmail($to,$subject,$body){
            Yii::$app->mailer->compose()
            ->setTo([$to])
            ->setFrom("noreply@my-novel.online")
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send();
    
            return true;
        }
}
