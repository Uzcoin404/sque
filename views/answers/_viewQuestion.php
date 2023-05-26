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

                <?PHP IF($question->showGrand()):?>
                    <p class="grand"><?=$question->getGrand()?></p>
                <?PHP ENDIF;?>

                <?PHP IF($question->showPrice()):?>
                    <p class="price"><?= $question->getPrice();?></p>
                <?PHP ENDIF;?>
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
                       
                    <?php } ?>
                    <?php if($question->status == 4){ ?>
                        <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                    <?php } ?>

                <?PHP IF($question->statusMoreOpen() && $question->status == 6):?>
                    <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                    <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                <?PHP ENDIF;?>

                <div class="questions__list_element_btn">
                    <?PHP IF($question->status==4):?>
                        <a href="/questions/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <?PHP ELSEIF($question->status==5):?>
                        <a href="/questions/voting/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <?PHP ELSEIF($question->status==6):?>
                        <a href="/questions/close/<?=$question->id?>#<?=$user->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
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
                <p class="text"><?=$question->gettext();?></p>
                <div class="questions__list_element_text_price">
                    <?PHP IF($question->showGrand()):?>
                            <p class="grand"><?=$question->getGrand()?></p>
                    <?PHP ENDIF;?>
                    <?PHP IF($question->showPrice()):?>
                        <p class="price"><?= $question->getPrice();?></p>
                    <?PHP ENDIF;?>
                    <?PHP if($question->status < 6){ ?>
                        <p class="status_time"><?=$question->getDateStatus()?></p>
                    <?PHP } ?>
                    <?PHP if($question->status == 6 || $question->status == 4 || $question->status == 5){?>
                        <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
                    <?PHP } ?>
                    <?PHP IF($question->statusMoreOpenBlock()):?>                        
                        <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                    <?PHP ENDIF;?>
                    <?PHP IF($question->statusMoreOpen()):?>
                        <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                        <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                    <?PHP ENDIF;?>
                </div>
            </div>
                <div class="questions__list_element_btn">
                    <a href="/questions/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <div class="status_time">
                        <?=$question->getDateStatus()?>
                    </div>
                </div>
        </div>
    <?PHP ENDIF;?>
<?PHP ENDIF;?>

