<?php 
    use app\models\Answers;
    $this->title = \Yii::t('app', 'My questions'); 
?>
<div class="questions">
    <div class="questions__list">
            <?PHP 
                FOREACH($questions as $question):
            ?>
                <?=Yii::$app->controller->renderPartial("moderation/_viewQuestion",["question"=>$question]);?>
            <?PHP 
                ENDFOREACH;
            ?>
    </div>
</div>