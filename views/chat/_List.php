<?php 
    use app\models\User; 
    use yii\widgets\LinkPager;
    //$pages->offset
    //print_r($pages->limit); exit;
?>
<div class="chat_list">
    <div class="chat_list__list">
        <?PHP $I=1;?>
        <?PHP FOREACH($chats as $chat):?>
            <?PHP IF($I>$pages->offset && $I<=$pages->offset+$pages->limit):?>
                <?php $username = User::find()->where(["id"=>$chat])->one() ?>
                <div class="chat_list__list_element">
                    <p class="title"><?=$username->username?></p>
                    <a href="/chatadmin/<?=$chat?>"><?=Yii::t('app','Next')?></a>
                </div>
            <?PHP endif;?>
            <?PHP $I++;?>
        <?PHP ENDFOREACH;?>
    </div>
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>