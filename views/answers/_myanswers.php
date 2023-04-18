<?php 
    use app\models\Questions;
    $this->title = \Yii::t('app', 'My voting'); 
?>
<div class="questions">
    <div class="questions__list">
        <?php 
            foreach($answer as $value){ 
                $questions = Questions::find()->where(['id'=>$value->id_questions])->all();
        ?>
        <?PHP FOREACH($questions as $question):?>
            <?=Yii::$app->controller->renderPartial("_viewQuestion",["question"=>$question]);?>
        <?PHP ENDFOREACH;?>
        <?php } ?>
    </div>
    <div class="questions_menu" style="display:none">
        <div class="questions_menu__buttons">
            <?PHP  IF(!Yii::$app->user->isGuest):?>
                <a href="/question/create" class="btn">
                    <?=\Yii::t('app', 'Create question');?>
                </a>
            <?PHP ENDIF;?>
        </div>
    </div>
</div>