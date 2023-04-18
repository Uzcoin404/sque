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

        $favourites = Favourites::find()->where(["id_question"=>$this->question_id, "id_user"=>$user->id])->all();
            
        return $this->render("favourites/index",["favourites"=>$favourites, "id_question"=>$this->question_id]);
       
    }


}
