
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
                <p class="grand"><?=$question->grand?></p>
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
            <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
            <?php if($question->status >= 5){ ?>
                <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
            <?php } ?>
            <?php if($question->status == 4){ ?>
                <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
            <?php } ?>
            <div class="questions__list_element_btn">
              
                <a href="/questions/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                <div class="status_time">
                    <?=$question->getDate()?>
                </div>
            </div>
        </div>
        <div class="questions__list_element_text_moderation">
            <button onclick="ModerationStatusPublic(this)" data-id-question="<?=$question->id?>" data-status="0">Вернуть</button>
            <?php if($question->status < 4){ ?>
                <button onclick="ModerationStatusPublic(this)" data-id-question="<?=$question->id?>" data-status="1">Опубликовать</button>
            <?php } ?>
        </div>
    </div>

</div>
<?php
    }
?>
