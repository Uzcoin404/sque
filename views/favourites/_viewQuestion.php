
<?php
    if(!$question){
        return 0;
    }
    $user=Yii::$app->user->identity;    
?>
<?PHP IF($user):?>
    <div class="questions__list__element">
        <div class="questions__list_element_text">
            <p class="title"><?=$question->getTitle();?></p>
            <p class="text"><?=$question->getText();?></p>
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
                <?PHP if($question->status < 6){ ?>
                    <p class="status_time"><?=$question->getDateStatus()?></p>
                <?PHP } ?>
                <?PHP if($question->status == 6 || $question->status == 4 || $question->status == 5){?>
                    <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
                <?PHP } ?>
                <?php if($question->status >= 5){ ?>
                    <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                <?php } ?>
                <?php if($question->status == 6){ ?>
                    <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                    <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                <?php } ?>
                <div class="questions__list_element_btn">
                
                <?PHP IF($question->status==4):?>
                        <a href="/questions/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <?PHP ELSEIF($question->status==5):?>
                        <a href="/questions/voting/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <?PHP ELSEIF($question->status==6):?>
                        <a href="/questions/close/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <?PHP ENDIF;?>

                </div>
            </div>
        </div>

    </div>
<?PHP ELSE:?>
    <?PHP IF($question->statusIsClosePay()):?>
        <div class="questions__list__element">
            <div class="questions__list_element_text">
                <p class="title"><?=$question->getTitle();?></p>
                <p class="text"><?=$question->getTexxt();?></p>
                <div class="questions__list_element_text_price">
                    <?php
                        if($question->grand){
                    ?>
                        <p class="grand"><?=$question->grand?></p>
                    <?php
                        }
                    ?>
                    <p class="price"><?= number_format($question->coast, 0, ' ', ' ') ?></p>
                    <?PHP if($question->status == 6 || $question->status == 4 || $question->status == 5){?>
                        <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
                    <?PHP } ?>
                    <?PHP if($question->status == 6){?>
                        <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
                    <?PHP } ?>
                    <?php if($question->status >= 5){ ?>
                        <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                    <?php } ?>
                    <?php if($question->status == 6){ ?>
                        <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                        <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                    <?php } ?>
                </div>
            </div>
                <div class="questions__list_element_btn">
                    <?PHP IF($question->status==4):?>
                        <a href="/questions/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <?PHP ELSEIF($question->status==5):?>
                        <a href="/questions/voting/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <?PHP ELSEIF($question->status==6):?>
                        <a href="/questions/close/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <?PHP ENDIF;?>
                </div>
        </div>
    <?PHP ENDIF;?>
<?PHP ENDIF;?>
