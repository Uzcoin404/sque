<?php
    $this->title = \Yii::t('app', 'Read'); 
    $user = Yii::$app->user->identity;
?>
<div class='read'>
    <div class='read__list'>
        <div class="read__list_element">
            <?=Yii::$app->controller->renderPartial("//../widgets/views/user/_text_read");?>  
        </div>
        <?php if($user && $user->read==0){ ?>
            <div class="read__list_button">
                <button class="accept" onclick="AcceptRead()"><?=Yii::t('app','Accept')?></button>
                <button class="close" onclick="CloseRead()"><?=Yii::t('app','Reject')?></button>
            </div>
        <?php } ?>
    </div>
</div>