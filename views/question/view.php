
<div class="questions">
    <div class="questions__list">
        <?PHP FOREACH($questions as $question):?>
            <div class="questions__list__element full">
                <div class="questions__list_element_text">
                    <p class="title"><?=$question->title?></p>
                    <p class="text"><?=$question->text?></p>
                    <?php
                        $this->title = $question->title;
                    ?>
                </div>
                <div class="questions__list_element_text_price">
                        <div class="questions__list_element_text_price_full">
                            <?php
                                if($question->grand){
                            ?>
                            <p class="grand"><?=$question->grand?></p>
                            <?php
                                }
                            ?>
                            <p class="price"><?= number_format($question->coast, 0, ' ', ' ') ?></p>
                            <p class="status <?=$question->getStatusClassName()?>"><?=$question->getStatusName()?></p>
                            <?= \app\widgets\Viewspost::widget(['question_id' => $question->id,"addView"=>1]) ?>
                            <?php if($question->status == 5){ ?>
                                <?= \app\widgets\Likepost::widget(['question_id' => $question->id]) ?>
                                <?= \app\widgets\Dislikepost::widget(['question_id' => $question->id]) ?>
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
        <div class='answers_post'>
            <div class='answers_post__list'>
                <?= \app\widgets\Answersblock::widget(['question_id' => $question->id, 'status' => $question->status]) ?>
            </div>
        </div>
    </div>
</div>

<?php

$this->registerJs(
    "    
    $(document).ready(function(){
        key = 'KmbD4ASdgbla@FGLbiskFzxb';
        var i = 0;
        var number = $('.answers_post__list .answers_post__list_element').length;
        var id = 0;
        var user = 0;
        while(i <= number){
            $('.btn_like_answer.block'+i+'').on('click', function() {
                id = $(this).attr('data-id');
                user = $(this).attr('data-user');
                $('.btn_like_answer').prop('disabled', true);
                $('.btn_dislike_answer').prop('disabled', true);
                $(this).css('height', '20px');
                $(this).css('background','url(/icons/like_before.png)');
                $('.btn_questions').each(function(){
                    this.href += '?like='+key+'&id_answer='+id+'';
                })
                $('.btn_questions').css('pointer-events', 'auto');
            });
            $('.btn_dislike_answer.block'+i+'').on('click', function() {
                id = $(this).attr('data-id');
                user = $(this).attr('data-user');
                $('.btn_like_answer').prop('disabled', true);
                $('.btn_dislike_answer').prop('disabled', true);
                $(this).css('height', '20px');
                $(this).css('background','url(/icons/dislike_before.png)');
                $('.btn_questions').each(function(){
                    this.href += '/dislike?dislike='+key+'&id_answer='+id+'';
                })
                $('.btn_questions').css('pointer-events', 'auto');
            });
            i++;
        }
    });
    "
);


?>

<script src="../../js/like.js"></script>
