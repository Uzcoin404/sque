<?php $this->title = \Yii::t('app', 'Chat'); ?>
<div class="chat">
    <div class="chat__list">
        <?PHP FOREACH($chats as $chat):?>
            <?=Yii::$app->controller->renderPartial("_User",["chat"=>$chat]);?>
        <?PHP ENDFOREACH;?>
        <div class="chat__list_controller">
            <?=$this->render('_form',[
                'model' => $model,
            ])?>
        </div>
    </div>
</div>

