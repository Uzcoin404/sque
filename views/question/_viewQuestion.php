
<?php
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

        </div>

    </div>
<?PHP ELSE:?>
    <?PHP IF($question->statusIsClosePay() || $question->statusIsCloseNoPay() ):?>
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
                    <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
                    <?php if($question->status >= 5){ ?>
                        <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                    <?php } ?>
                    <?php if($question->status >= 4){ ?>
                        <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                        <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                    <?php } ?>
                    <div class="questions__list_element_btn">
                        
                        <a href="/questions/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                        <div class="status_time">
                            <?=$question->getDate()?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?PHP ENDIF;?>
<?PHP ENDIF;?>