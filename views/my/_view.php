
<?php
    $user=Yii::$app->user->identity;    
?>
<?PHP IF($user && $user->read == 1):?>
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
                    if($question->status < 6){
                ?>
                    <p class="status <?=$question->getStatusClassName()?>"><?=$question->getStatusName()?> / <?=$question->getDateStatus()?></p>
                <?php
                    } elseif($question->status == 6) {
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
                    <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                    <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                <?php } ?>
                <?php if($question->status == 4){ ?>
                    <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                <?php } ?>
                <div class="questions__list_element_btn">
                    <?php if($question->status == 2){?>
                        <a onclick="BlockReturn(<?=$question->id?>)" class="btn_questions"><?=\Yii::t('app','Reason for return')?></a>
                        <a href="/questions/change/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','Change')?></a>
                        <a href="/questions/myquestions/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <?php
                        } else{
                    ?>
                        <a href="/questions/myquestions/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <?php
                        }
                    ?>
                </div>
            </div>

        </div>

    </div>
    <?php if($question->status == 2){ ?>
        <div class="block_return <?=$question->id?>">
            <div class="block_return_back" onclick="BlockReturnClose(<?=$question->id?>)"></div>
            <div class="block_return__list">
                <div class="block_return__list_element">
                    <p class="title"><?=\Yii::t('app','Reason for return')?></p>
                    <p class="text"><?=$question->text_return?></p>
                </div>
            </div>
        </div>
    <?php } ?>
<?PHP ELSE:?>
        <div class="questions__list__element">
            <div class="questions__list_element_text">
                <p class="title"><?=$question->getTitle();?></p>
                <p class="text"><?=$question->getText();?></p>
                <div class="questions__list_element_text_price">
                    <?php
                        if($question->grand){
                    ?>
                        <p class="grand"><?=$question->grand?></p>
                    <?php
                        }
                    ?>
                    <p class="price"><?= number_format($question->coast, 0, ' ', ' ') ?></p>
                    <p class="status <?=$question->getStatusClassName()?>"><?=$question->getStatusName()?> / <?=$question->getDateStatus()?></p>
                    <?php if($question->status == 6){?>
                        <?= \app\widgets\Statusdatepost::widget(['question_id' => $question->id]) ?>
                        <?= \app\widgets\Statusdatevotepost::widget(['question_id' => $question->id]) ?>
                    <?php } ?>
                    <?PHP if($question->status == 6 || $question->status == 4 || $question->status == 5){?>
                        <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
                    <?PHP } ?>
                    <?php if($question->status >= 5){ ?>
                        <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                    <?php } ?>
                    <?php if($question->status >= 6){ ?>
                        <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                        <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                    <?php } ?>
                    <div class="questions__list_element_btn">
                        
                        <a href="/questions/myquestions/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>

                    </div>
                </div>
            </div>
        </div>
<?PHP ENDIF;?>