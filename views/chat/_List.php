<?php 
    use app\models\User; 
    use yii\widgets\LinkPager;
    use app\models\Chat;
    //$pages->offset
    //print_r($pages->limit); exit;
?>
<div class="chat_list">
    <div class="chat_list__list">
        <?PHP $I=1;?>
        <?PHP FOREACH($chats as $user_id=>$chat):?>
            <?PHP IF($I>$pages->offset && $I<=$pages->offset+$pages->limit):?>
                <?php $username = User::find()->where(["id"=> $user_id])->one() ?>
                <div class="chat_list__list_element">
                    <div class="wrapp">
                        <p class="title"><?=$username->username?></p>
                        <?PHP $no_read_count=Chat::GetNoRead($username->id);?>
                        <?PHP IF($no_read_count>0):?>
                        <span class="no_read_count"><?=$no_read_count;?></span>
                        <?PHP ENDIF;?>
                    </div>
                    <a href="/chatadmin/<?=$user_id?>"><?=Yii::t('app','Next')?></a>
                </div>
            <?PHP endif;?>
            <?PHP $I++;?>
        <?PHP ENDFOREACH;?>
    </div>
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>