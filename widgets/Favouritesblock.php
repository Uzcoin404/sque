<?php

namespace app\widgets;

use Yii;
use app\models\Favourites;



class Favouritesblock extends \yii\bootstrap5\Widget
{
    public $question_id = 0;
   
    public function run()
    {
        $user=Yii::$app->user->identity;

        $favourites = Favourites::find()->where(["question_id"=>$this->question_id, "user_id"=>$user->id])->all();
            
        return $this->render("favourites/index",["favourites"=>$favourites, "question_id"=>$this->question_id]);
       
    }


}
