<?php
    $this->title = \Yii::t('app', 'Read'); 
    $user = Yii::$app->user->identity;
    if($href=="term"){
        $this->title = \Yii::t('app', 'Terms of Use');
    }
    if($href=="privacy"){
        $this->title = \Yii::t('app', 'Privacy policy');
    }
    if($href=="register"){
        $this->title = \Yii::t('app', 'Disclaimer for registered users');
    }
    if($href=="unregister"){
        $this->title = \Yii::t('app', 'Disclaimer for Unregistered Users');
    }
?>
<div class='read'>
    <div class='read__list'>
        <div class="read__list_element">
            <?=$html;?>  
        </div>
        <?php if($user && $user->read==0){ ?>
            <div class="read__list_button">
                <button class="accept" onclick="AcceptRead()"><?=Yii::t('app','Accept')?></button>
                <button class="close" onclick="CloseRead()"><?=Yii::t('app','Reject')?></button>
            </div>
        <?php } ?>
    </div>
</div>