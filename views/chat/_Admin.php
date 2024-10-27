<?php

    $result = "";

    $first_date = new \DateTime("now");
    $second_date = new \DateTime("@".$chat->created_at);
    $interval = $second_date->diff($first_date);
    if($interval->days <= 0){
        $result= \Yii::t('app','{i} minutes back',['i'=>$interval->i]);
    } else {
        $result= \Yii::t('app', '{d} days {h} hours',['d'=>$interval->d,'h'=>$interval->h]);
    }

?>
<div class="chat__list_element">

    <div class="chat__list_element_display_sender">
        <div class="chat__list_element_display_user">
            <?=$name_sender?>:
        </div>
        <div class="chat__list_element_display_text">
            <?=$chat->text?>
        </div>
        <div class="chat__list_element_display_date">
            <?=$second_date->format('d.m.Y')?>
        </div>
    </div>


</div>