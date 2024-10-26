
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
                    <?php if($question->status > 5){ ?>
                        <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                    <?php } ?>
                    <?php if($question->status == 4){ ?>
                        <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                    <?php } ?>
                <div class="questions__list_element_btn">
                
                <?PHP IF($question->status==4):?>
                        <a href="/favourit/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <?PHP ELSEIF($question->status==5):?>
                        <a href="/favourit/voting/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <?PHP ELSEIF($question->status==6):?>
                        <a href="/favourit/close/<?=$question->id?>#<?=$user->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
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
