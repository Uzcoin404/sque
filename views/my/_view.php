
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
                <p class="price"><?= number_format($question->cost, 0, ' ', ' ') ?></p>
                <?php
                    if($question->status < 6 && $question->status > 2){
                ?>
                    <p class="status <?=$question->getStatusClassName()?>"><?=$question->getDateStatus()?> / <?=$question->getStatusName()?></p>
                <?php
                    } elseif($question->status == 6) {
                ?>
                    <p class="status <?=$question->getStatusClassName()?>"><?=$question->getStatusName()?></p>
                    <?= \app\widgets\Likeanwsers::widget(['question_id' => $question->id]) ?>
                <?php
                    } elseif ($question->status == 1 || $question->status == 2){
                ?>
                    <p class="status <?=$question->getStatusClassName()?>"><?=$question->getStatusName()?></p>
                <?php
                    }
                ?>
                <?PHP if($question->status == 6 || $question->status == 4 || $question->status == 5){?>
                    <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
                    <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                <?PHP } ?>
                <div class="questions__list_element_btn">
                    <?php if($question->status == 2){?>
                        <a onclick="BlockReturn(<?=$question->id?>)" class="btn_questions"><?=\Yii::t('app','Reason for return')?></a>
                        <a href="/questions/change/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','Change')?></a>
                        <?PHP IF($question->status==4):?>
                            <a href="/questions/myquestions/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                        <?PHP ELSEIF($question->status==5):?>
                            <a href="/questions/myquestions/voting/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                        <?PHP ELSEIF($question->status==6):?>
                            <a href="/questions/myquestions/close/<?=$question->id?>#<?=$user->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                        <?PHP ENDIF;?>
                    <?php
                        } else{
                    ?>
                        <?PHP IF($question->status==4):?>
                            <a href="/questions/myquestions/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                        <?PHP ELSEIF($question->status==5):?>
                            <a href="/questions/myquestions/voting/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                        <?PHP ELSEIF($question->status==6):?>
                            <a href="/questions/myquestions/close/<?=$question->id?>#<?=$user->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                        <?PHP ENDIF;?>
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
                    <?= \app\widgets\Favouritesblock::widget(['question_id' => $question->id]) ?>
                    <?php
                        if($question->grand){
                    ?>
                        <p class="grand"><?=$question->getGrand()?></p>
                    <?php
                        }
                    ?>
                    <p class="price"><?= number_format($question->cost, 0, ' ', ' ') ?></p>
                    <?php
                        if($question->status < 6 && $question->status > 2){
                    ?>
                        <p class="status <?=$question->getStatusClassName()?>"><?=$question->getDateStatus()?> / <?=$question->getStatusName()?></p>
                    <?php
                        } elseif($question->status == 6) {
                    ?>
                        <p class="status <?=$question->getStatusClassName()?>"><?=$question->getStatusName()?></p>
                        <?= \app\widgets\Likeanwsers::widget(['question_id' => $question->id]) ?>
                    <?php
                        } elseif ($question->status == 1 || $question->status == 2){
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
<?PHP ENDIF;?>
