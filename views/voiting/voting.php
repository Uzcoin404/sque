
<?php 

    $this->title = \Yii::t('app', 'Voting questions'); 
    use yii\widgets\LinkPager;
?>

<div class="questions">
    <div class="questions__list">
        <?PHP FOREACH($questions as $question):?>
            <?=Yii::$app->controller->renderPartial("_voiting",["question"=>$question]);?>
        <?PHP ENDFOREACH;?>
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
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>