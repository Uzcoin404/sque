
<?php
    $user=Yii::$app->user->identity;    
    if($user){
?>

<div class="questions__list__element">
    <div class="questions__list_element_text">
        <p class="title"><?=$question->getTitle(1);?></p>
        <p class="text"><?=$question->getText(1);?></p>
        <div class="questions__list_element_text_price">
            <?= \app\widgets\Favouritesblock::widget(['question_id' => $question->id]) ?>
            <?php
                if($question->grand){
            ?>
                <p class="grand"><?=$question->getGrand()?></p>
            <?php
                }
            ?>
            <p class="price"><?= number_format($question->coast, 0, ' ', ' ') ?></p>
            <?php
                if($question->status > 7 || $question->status < 7){
            ?>
                <p class="status <?=$question->getStatusClassName()?>"><?=$question->getStatusName()?></p>
            <?php
                }
            ?>
            <?PHP if($question->status == 6 || $question->status == 4 || $question->status == 5){?>
                <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
            <?PHP } ?>
            <?php if($question->status > 5){ ?>
                <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                
                <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
            <?php } ?>
            <?php if($question->status == 4){ ?>
                <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
            <?php } ?>
            <div class="questions__list_element_btn">
              
                <a href="/questions/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                
            </div>
        </div>
        <div class="questions__list_element_text_moderation">
                <a href="/questions/return/<?=$question->id?>"><?=Yii::t("app","Return")?></a>
            <?php if($question->status < 4){ ?>
                <button onclick="ModerationStatusPublic(this)" data-id-question="<?=$question->id?>" data-status="1"><?=Yii::t("app","Public")?></button>
            <?php } ?>
        </div>
    </div>

</div>
<?php
    }
?>
