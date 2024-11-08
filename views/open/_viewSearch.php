
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
                    if($question->status < 6){
                ?>
                    <p class="status <?=$question->getStatusClassName()?>"><?=$question->getDateStatus()?> / <?=$question->getStatusName()?></p>
                <?php
                    } elseif($question->status == 6) {
                ?>
                    <p class="status <?=$question->getStatusClassName()?>"><?=$question->getStatusName()?></p>
                <?php
                    }
                ?>
                    <?PHP if($question->status == 6 || $question->status == 4 || $question->status == 5){?>
                        <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
                    <?PHP } ?>
                <?php if($question->status >= 5){ ?>
                    <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                    
                    <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                <?php } ?>
                <?php if($question->status == 4){ ?>
                    <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                <?php } ?>
                <div class="questions__list_element_btn">
                    <?php if($question->status == 2){?>
                        <a href="/questions/change/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','Change')?></a>
                        <?PHP IF($question->status==4):?>
                            <a href="/questions/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                        <?PHP ELSEIF($question->status==5):?>
                            <a href="/questions/voting/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                        <?PHP ELSEIF($question->status==6):?>
                            <a href="/questions/close/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                        <?PHP ENDIF;?>
                    <?php
                        } else{
                    ?>
                    <?php

                      $url = '';

                      if($question->status == 4){
                        $url = '/questions/view/';
                      }
                      if($question->status == 5){
                        $url = '/questions/voting/';
                      }
                      if($question->status == 6){
                        $url = '/questions/close/';
                      }
                    
                    ?>
                        <?PHP IF($question->status==4):?>
                            <a href="/questions/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                        <?PHP ELSEIF($question->status==5):?>
                            <a href="/questions/voting/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                        <?PHP ELSEIF($question->status==6):?>
                            <a href="/questions/close/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
                        <?PHP ENDIF;?>
                    <?php
                        }
                    ?>
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
                    <p class="price"><?= number_format($question->cost, 0, ' ', ' ') ?></p>
                    <?php
                        if($question->status < 6){
                    ?>
                        <p class="status <?=$question->getStatusClassName()?>"><?=$question->getDateStatus()?> / <?=$question->getStatusName()?></p>
                    <?php
                        } elseif($question->status == 6) {
                    ?>
                        <p class="status <?=$question->getStatusClassName()?>"><?=$question->getStatusName()?></p>
                    <?php
                        }
                    ?>
                    <?PHP if($question->status == 6 || $question->status == 4 || $question->status == 5){?>
                        <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
                    <?PHP } ?>
                    <?php if($question->status >= 5){ ?>
                        <?= \app\widgets\Answerspost::widget(['question_id' => $question->id]) ?>
                    <?php } ?>
                    <?php if($question->status >= 6){ ?>
                        
                        <p class="username"><?= \app\widgets\AnswerNameUser::widget(['question_id' => $question->id]) ?></p>
                    <?php } ?>
                    <div class="questions__list_element_btn">
                    <?php

                      $url = '';

                      if($question->status == 4){
                        $url = '/questions/view/';
                      }
                      if($question->status == 5){
                        $url = '/questions/voting/';
                      }
                      if($question->status == 6){
                        $url = '/questions/close/';
                      }
                    ?>
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
