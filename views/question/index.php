<div class="questions">
    <div class="questions__list">
        <?PHP FOREACH($questions as $question):?>
            <?=$this->rendePartial("_viewQuestion",["question"=>$question]);?>
        <?PHP ENDFOREACH;?>
    </div>
    <div class="questions_menu">
        <div class="questions_menu__buttons">
            <?PHP  IF(!Yii::$app->user->isGuest):?>
                <a href="/question/create" class="btn">
                    <?=\Yii::t('app', 'Create question');?>
                </a>
            <?PHP ENDIF;?>
        </div>
    </div>
</div>