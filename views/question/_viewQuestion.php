<div class="questions__list__element">
    <div class="questions__list_element_text">
        <p class="title"><?=$question->title;?></p>
        <p class="text"><?=$question->text;?></p>
        <div class="questions__list_element_text_price">
            <?php
                if($question->grand){
            ?>
                <p class="grand"><?=$question->grand?></p>
            <?php
                }
            ?>
            <p class="price"><?= number_format($question->coast, 0, ' ', ' ') ?></p>
            <p class="status <?=$question->getStatusClassName()?>"><?=$question->getStatusName()?></p>
            <?= \app\widgets\Viewspost::widget(['question_id' => $question->id]) ?>
        </div>
    </div>
        <div class="questions__list_element_btn">
            <div class="status_time">
                <?=$question->getDate()?>
            </div>
            <a href="/questions/view/<?=$question->id?>" class="btn_questions"><?=\Yii::t('app','More detailed')?></a>
        </div>
</div>