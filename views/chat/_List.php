<?php 
    use app\models\User; 
?>
<div class="chat_list">
    <div class="chat_list__list">
        <?PHP FOREACH($chats as $chat):?>
            <?php $username = User::find()->where(["id"=>$chat])->one() ?>
            <div class="chat_list__list_element">
                <p class="title"><?=$username->username?></p>
                <a href="/chatadmin/<?=$chat?>"><?=Yii::t('app','Next')?></a>
            </div>
        <?PHP ENDFOREACH;?>
    </div>
</div>