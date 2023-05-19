<?php $users=Yii::$app->user->identity; ?>
<?php if($users){ ?>
    <a href="#<?=$users->id?>" class="seacrh_answers"><?=Yii::t('app','Seacrh my answers')?></a>
<?php } ?>
<div class='answers_post'>
    <div class='answers_post__list'>
        <?PHP 
         foreach($answers as $answer):?>
            <?=Yii::$app->controller->renderPartial("//../widgets/views/answers/_view",["answer"=>$answer,"id_questions"=>$id_questions,'orderWinner'=>$orderWinner]);?>
        <?PHP ENDFOREACH;?>
    </div>
</div>