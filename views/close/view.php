
<?php 

    $user=Yii::$app->user->identity;

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
                                <?= \app\widgets\Likeanwsers::widget(['question_id' => $question->id]) ?>
                                <p class="status <?=$question->getStatusClassName()?>"><?=$question->getStatusName()?></p>

                                <?= \app\widgets\Statusdatepost::widget(['question_id' => $question->id]) ?>
                                <?= \app\widgets\Statusdatevotepost::widget(['question_id' => $question->id]) ?>
                                <?= \app\widgets\Viewspost::widget(['question_id' => $question->id,"addView"=>1]) ?>
                                <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                                <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                                <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                        </div>
         
                </div>
        </div>
        <?= \app\widgets\Answersblock::widget(['question_id' => $question->id,'orderWinner'=>1]) ?>
        
       
    </div>
</div>


