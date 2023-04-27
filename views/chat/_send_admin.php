<?php 

    use app\models\User;

    $this->title = \Yii::t('app', 'Chat'); 

    $user=Yii::$app->user->identity;
    if($user){
        $sender_name = $user->username;
    } else {
        $sender_name = \Yii::t('app', 'Guest');
    }
 
?>
<div class="chat">
    <div class="chat__list">
        <p class="title"><?=\Yii::t('app', 'Chat')?></p>
        <?PHP FOREACH($chats as $chat):?>
            <?php if($chat->sender_id == $user->id && $chat->recipient_id == $id){
            ?>
                <?=Yii::$app->controller->renderPartial("_User",["chat"=>$chat,"name_sender"=>$sender_name]);?>
            <?php
            } 
            ?>
            <?php if($chat->sender_id == $id){
                $name = User::find()->where(["id"=>$chat->sender_id])->one();
            ?>
                <?=Yii::$app->controller->renderPartial("_Admin",["chat"=>$chat,"name_sender"=>$name->username]);?>
            <?php
            } 
            ?>
        <?PHP ENDFOREACH;?>
        <div class="chat__list_controller">
            <?=$this->render('_form',[
                'model' => $model,
            ])?>
        </div>
    </div>
</div>

