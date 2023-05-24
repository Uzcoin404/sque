<?php $users=Yii::$app->user->identity; ?>
<?=Yii::$app->controller->renderPartial("//../widgets/views/answers/_search_answers",["id_questions"=>$id_questions]);?>
<div class='answers_post'>
    <div class='answers_post__list'>
        <?PHP 
         foreach($answers as $answer):?>
            <?=Yii::$app->controller->renderPartial("//../widgets/views/answers/_view",["answer"=>$answer,"id_questions"=>$id_questions,'orderWinner'=>$orderWinner]);?>
        <?PHP ENDFOREACH;?>
    </div>
</div>