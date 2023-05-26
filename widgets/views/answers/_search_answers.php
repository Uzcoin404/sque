<?php 
    use app\models\Questions;
    $users=Yii::$app->user->identity; 
    $questions = Questions::find()->where(['id'=>$id_questions])->one();
?>
<div class="seacrh">
    <div class="seacrh__list">
        <?php if($users){ ?>
            <?php if($questions->status == 5 || $questions->status == 6){?>
                <a href="#<?=$users->id?>" class="seacrh_answers_users"><?=Yii::t('app','Seacrh my answers')?></a>
            <?php } ?>
            <?php if($questions->status == 6){?>
                <div class="seacrh__list_filterlike">
                    <a><?=Yii::t('app','Sort')?>:</a>
                    
                </div>
                <a class="seacrh_answers like" onclick="FilterLike(this)" data-id="<?=$questions->id?>" data-sort="ALL"><?=Yii::t('app','Sort like')?></a>
                <a class="seacrh_answers dislike" onclick="FilterDislike(this)" data-id="<?=$questions->id?>" data-sort="ALL"><?=Yii::t('app','Sort dislike')?></a>
            <?php } ?>
        <?php } ?>
    </div>
</div>
