<?php 

$this->title = \Yii::t('app', 'My favourites');
use yii\widgets\LinkPager;
use app\models\Questions;

?>
<div class="questions">
    <div class="questions__list">
        <?PHP 
            if(!$model){
                echo "<p>".\Yii::t('app', 'You dont have a favorite')."</p>";
            }
            FOREACH($model as $question):
        ?>
                
                <?=Yii::$app->controller->renderPartial("_viewQuestion",["question"=>$question]);?>
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
