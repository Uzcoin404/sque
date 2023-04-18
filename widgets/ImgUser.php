<?php

namespace app\widgets;

use Yii;
use app\models\User;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
class ImgUser extends \yii\bootstrap5\Widget
{
    public $question_id=0;
    public $user_id=0;
    public $dislike_submit = '';
    public function init()
    {
        parent::init();
        if(isset(\Yii::$app->user->identity->id)){
            $this->user_id=\Yii::$app->user->identity->id;
            $this->dislike_submit = 'DislikeSubmit()';
        }
    }
    public function run()
    {

        $user=Yii::$app->user->identity;

        $models = User::find()->where(["id"=>$user->id])->all();
        
        return $this->render("user/index",["models"=>$models]);

    }
    
}