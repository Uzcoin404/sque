<?php $users=Yii::$app->user->identity; ?>
<?PHP 
    foreach($answers as $answer):?>
    <?=Yii::$app->controller->renderPartial("//../widgets/views/answers/_view",["answer"=>$answer,"id_questions"=>$answer->id_questions,'orderWinner'=>$answer->number]);?>
<?PHP ENDFOREACH;?>
