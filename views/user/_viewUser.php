<div class="user__list_element">
    <div class="user__list_element_img">
        
        <p class="title"><?=$users->username?></p>
    </div>
    <div class="user__list_element_text">
        <a href="mailto:<?=$users->email?>" class="email"><?=$users->email?></a>
        <p class="balance">
            <?php
                if(!$users->money){
                    $users->money = 0;
                }
            ?>
            <?=$users->money?>
        </p>
        <p class="date">
            <?=Yii::t("app","Date registration")?>:
            <?php
                $users->create_at = date("d.m.y",$users->create_at);
            ?>
            <?=$users->create_at?>
        </p>
        <p class="ready">
            <?php
                if($users->status == 1){
                    $users->status = Yii::t("app","Accept email");
                } else {
                    $users->status = Yii::t("app","Not accept email");
                }
            ?>
            <?=$users->status?>
        </p>
        <p class="grand">
            <?php
                if($users->read == 1){
                    $users->read = Yii::t("app","Read accept");
                } else {
                    $users->read = Yii::t("app","Read not accept");
                }
            ?>
            <?=$users->read?>
        </p>
        <p class="id">
            <?=Yii::t("app","Number user")?>:
            <?=$users->id?>
        </p>
        <p class="admin">
            <?php
                if($users->moderation == 1){
                    $users->moderation = Yii::t("app","Moderation");
                } else {
                    $users->moderation = Yii::t("app","User");
                }
            ?>
            <?=$users->moderation?>
        </p>
        <p class="grand">
            <?php
                
                 Yii::t("app","Citizenship");
           
             
            ?>
            <?=$users->getGrand()?>
        </p>
    </div>
</div>