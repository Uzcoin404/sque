<?php $users=Yii::$app->user->identity; ?>
<?PHP 
    foreach($answers as $answer):?>
    <?=Yii::$app->controller->renderPartial("//../widgets/views/answers/_view",["answer"=>$answer,"question_id"=>$answer->question_id,'orderWinner'=>$answer->number]);?>
<?PHP ENDFOREACH;?>
