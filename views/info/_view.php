

<div class="complaints__list_element">
    <div class="complaints__list_element_reason">
        <p class="title"><?=$value->name_status?></p>
        <p><?=Yii::t('app','Text Russian')?>: <?=$value->text_ru?></p>
        <p><?=Yii::t('app','Text English')?>: <?=$value->text_eng?></p>
    </div>
            
    <div class="complaints__list_element_btn">
            <a href="info/update_list/<?=$value->id?>" class="question_btn">Изменить</a>
    </div>

</div>