
<?php 

    $user=Yii::$app->user->identity;
    use app\models\Answers;
?>
<?=Yii::$app->controller->renderPartial("//../widgets/BackUrl", ['question_id' => $question->id]);?>
<div class="questions">
    <div class="questions__list">
            <?php \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
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
                                <?= \app\widgets\Viewspost::widget(['question_id' => $question->id,"addView"=>1]) ?>
                            <?PHP } ?>
                            <?php if($question->status >= 5){ ?>
                                <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                            <?php } ?>
                            <?php if($question->status > 5){ ?>
                                <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                                <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                            <?php } ?>
                            <?php if($question->status == 4){ ?>
                                <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                            <?php } ?>
                        </div>
                      
                </div>
        </div>
        <?php if(!$user){ ?>
            <div class="block_info_notauth" style="margin: 0px 0px 20px 0px;">
                <p class="info"><?=Yii::t('app','Only authorized users can vote for answers on the site, please Log in or Register!')?></p>
            </div>
        <?php } ?>
        <?= \app\widgets\Answersblock::widget(['question_id' => $question->id]) ?>
        
        <!-- <?PHP IF($question->statusMoreCloseNoPay()):?>
            <?= \app\widgets\Answersblock::widget(['question_id' => $question->id]) ?>
        <?PHP ENDIF;?> -->
       
    </div>
</div>


