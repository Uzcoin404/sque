<?php $users=Yii::$app->user->identity; ?>
<?=Yii::$app->controller->renderPartial("//../widgets/views/answers/_search_answers",["question_id"=>$question_id]);?>
<div class='answers_post'>
    <div class='answers_post__list'>
        <?PHP 
         foreach($answers as $answer):?>
            <?=Yii::$app->controller->renderPartial("//../widgets/views/answers/_view",["answer"=>$answer,"question_id"=>$question_id,'orderWinner'=>$orderWinner, "filter_status"=>0]);?>
        <?PHP ENDFOREACH;?>
    </div>
</div>