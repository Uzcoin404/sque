
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

                <?PHP IF($question->showGrand()):?>
                    <p class="grand"><?=$question->getGrand()?></p>
                <?PHP ENDIF;?>

                <?PHP IF($question->showPrice()):?>
                    <p class="price"><?= $question->getPrice();?></p>
                <?PHP ENDIF;?>

                <?PHP IF($question->statusNotClosePay()):?>
                    <p class="status <?=$question->getStatusClassName()?>"><?=$question->getStatusName()?></p>
                <?PHP ENDIF;?>

                <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>

                <?PHP IF($question->statusMoreOpenBlock()):?>
                    <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                <?PHP ENDIF;?>

                <?PHP IF($question->statusMoreOpen()):?>
                    <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                    <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                <?PHP ENDIF;?>

                <div class="questions__list_element_btn">
                    
                    <a href="/answer/myanswers/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    <div class="status_time">
                        <?=$question->getDate()?>
                    </div>
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
                    <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>

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
                        <?=$question->getDate()?>
                    </div>
                </div>
        </div>
    <?PHP ENDIF;?>
<?PHP ENDIF;?>