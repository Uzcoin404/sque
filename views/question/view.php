
<?php 

    $user=Yii::$app->user->identity;

?>
<div class="question_back__btn"><a  href="javascript:history.back()"><?=\Yii::t('app','Back')?></a></div>
<div class="questions">
    <div class="questions__list">
        <?PHP FOREACH($questions as $question):?>
            <div class="questions__list__element full">
                <div class="questions__list_element_text">
                    <p class="title"><?=$question->getTitle(1)?></p>
                    <p class="text"><?=$question->getText(1)?></p>
                    <?php
                        $this->title = $question->getTitle();
                    ?>
                </div>
                <div class="questions__list_element_text_price">
                        <div class="questions__list_element_text_price_full">
                            <?php
                             if($user){
                             echo \app\widgets\Favouritesblock::widget(['question_id' => $question->id]);
                            }
                            ?>
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
                            <?= \app\widgets\Viewspost::widget(['question_id' => $question->id,"addView"=>1]) ?>
                            <?php if($question->status >= 5){ ?>
                                <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                                <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                                <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                            <?php } ?>
                            <?php if($question->status == 4){ ?>
                                <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                            <?php } ?>
                        </div>
                        <?php
                            $user = Yii::$app->user->identity;
                            if($user){
                        ?>
                            <div class="questions__list_element_btn">
                                <?php
                                    if($question->status > 3 && $question->status < 6){
                                ?>
                                    <a href="/answer/create/<?=$question->id?>" class="btn_answers"><?=\Yii::t('app', 'Answer the question');?></a>
                                <?php
                                    }
                                ?>
                                <?php if($question->status == 5){ ?>
                                    <a OnClick="VoteSave()" class="btn_questions"><?=\Yii::t('app','Vote')?></a>
                                <?php } ?>
                            </div>
                        <?php
                            }
                        ?>
                </div>
        </div>
        <?PHP ENDFOREACH;?>
        <?PHP IF($question->statusMoreCloseNoPay()):?>
            <?= \app\widgets\Answersblock::widget(['question_id' => $question->id]) ?>
        <?PHP ENDIF;?>
       
    </div>
</div>

