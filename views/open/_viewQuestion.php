
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
                    <p class="grand"><?=$question->getGrand()?></p>
                <?php
                    }
                ?>
                <p class="price"><?= number_format($question->coast, 0, ' ', ' ') ?></p>
                <?php
                    if($question->status > 7 || $question->status < 7){
                ?>
                    <p class="status <?=$question->getStatusClassName()?>"><?=$question->getDateStatus()?> / <?=$question->getStatusName()?></p>
                <?php
                    }
                ?>
                <?php 
                    if($question->status == 6){ 
                ?>
                    <?= \app\widgets\Statusdatepost::widget(['question_id' => $question->id]) ?>
                    <?= \app\widgets\Statusdatevotepost::widget(['question_id' => $question->id]) ?>
                <?php
                    }
                ?>
                <?PHP if($question->status == 6 || $question->status == 4 || $question->status == 5){?>
                    <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
                <?PHP } ?>
                <?php if($question->status >= 5){ ?>
                    <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                    <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                    <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                <?php } ?>
                <?php if($question->status == 4){ ?>
                    <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                <?php } ?>
                <div class="questions__list_element_btn">
                    <?php if($question->status == 2){?>
                        <a href="/questions/change/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','Change')?></a>
                        <a href="/questions/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <?php
                        } else{
                    ?>
                        <a href="/questions/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <?php
                        }
                    ?>
                    <?php if($user->moderation == 1){ ?>
                        <a href="/questions/dateupdate/<?=$question->id?>" class="btn_questions"><?=Yii::t("app","Date update")?></a>
                    <?php } ?>
                </div>
            </div>

        </div>

    </div>
<?PHP ELSE:?>
        <div class="questions__list__element">
            <div class="questions__list_element_text">
                <p class="title"><?=$question->getTitle();?></p>
                <p class="text"><?=$question->getText();?></p>
                <div class="questions__list_element_text_price">
                    <?php
                        if($question->grand){
                    ?>
                        <p class="grand"><?=$question->getGrand()?></p>
                    <?php
                        }
                    ?>
                    <p class="price"><?= number_format($question->coast, 0, ' ', ' ') ?></p>
                    <p class="status <?=$question->getStatusClassName()?>"><?=$question->getDateStatus()?> / <?=$question->getStatusName()?></p>
                    <?php if($question->status == 6){?>
                        <?= \app\widgets\Statusdatepost::widget(['question_id' => $question->id]) ?>
                        <?= \app\widgets\Statusdatevotepost::widget(['question_id' => $question->id]) ?>
                    <?php } ?>
                    <?PHP if($question->status == 6 || $question->status == 4 || $question->status == 5){?>
                        <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
                    <?PHP } ?>
                    <?php if($question->status >= 4){ ?>
                        <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                    <?php } ?>
                    <?php if($question->status >= 6){ ?>
                        <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                        <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                    <?php } ?>
                    <div class="questions__list_element_btn">                        
                        <a href="/questions/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    </div>
                </div>
            </div>
        </div>
<?PHP ENDIF;?>
