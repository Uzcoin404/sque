<?php 
    use app\models\Answers;
    use yii\widgets\LinkPager;
    $this->title = \Yii::t('app', 'Moderation'); 
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
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>