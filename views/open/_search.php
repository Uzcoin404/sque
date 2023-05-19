<?php 
    use app\models\Answers;
    $user=Yii::$app->user->identity;
    $this->title = \Yii::t('app', 'Search questions'); 
?>
<div class="questions">
    <div class="questions__list">
            <?php
            
                if(!$questions){
                    echo Yii::t('app','Nothing was found for your query');
                }
               
            ?>

            <?PHP 
                FOREACH($questions as $question):
                if($question){
            ?>
                        <?=Yii::$app->controller->renderPartial("_viewSearch",["question"=>$question]);?>
            <?PHP 
                }
                ENDFOREACH;
            ?>
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