
<?php
    $user=Yii::$app->user->identity;  
    use app\models\Answers;

    if($user){
        $answer = Answers::find()->where(['id_user'=>$user->id,'id_questions'=>$question->id])->one();
    }
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
           
                    <p class="status <?=$question->getStatusClassName()?>"><?=$question->getStatusName()?></p>
                    <?= \app\widgets\Likeanwsers::widget(['question_id' => $question->id]) ?>
                    <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
                    <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                    <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                    <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
     

                <div class="questions__list_element_btn">
                        <?php if($answer){ ?>
                            <a href="/questions/close/<?=$question->id?>#<?=$user->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                        <?php } else { ?>
                            <a href="/questions/close/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
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
                    <p class="status <?=$question->getStatusClassName()?>"><?=$question->getStatusName()?></p>
 
                        <?= \app\widgets\Likeanwsers::widget(['question_id' => $question->id]) ?>
                        <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
                        <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>

                        <div class="avatar_owner" style="background: url(/img/users/<?= \app\widgets\AnswerImgUser::widget(['question_id' => $question->id]) ?>)"></div>
                        <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
    
                    <div class="questions__list_element_btn">
                        <a href="/questions/close/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                    </div>
                    

                </div>
            </div>
        </div>
<?PHP ENDIF;?>
