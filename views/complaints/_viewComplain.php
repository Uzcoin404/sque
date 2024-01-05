<?php
    use app\models\Answers;
    use app\models\User;
    use app\models\Questions;
    $answers = Answers::find()->where(["id"=>$complaints->id_answers])->one();
?>
<?PHP IF(isset($answers->id_user)):?>
    <?PHP
        $user = User::find()->where(["id"=>$answers->id_user])->one();
        $question = Questions::find()->where(["id"=>$answers->id_questions])->one();
    ?>
    <?PHP IF(isset($user->id)):?>
        <div class="complaints__list_element">
            <div class="complaints__list_element_reason">
                <p class="title"><?=Yii::t("app","Reason for complain")?></p>
                <p><?=$complaints->reason?></p>
            </div>
            <div class="complaints__list_element_comp">
                <p class="title"><?=Yii::t("app","Answer")?></p>
                <div class="complaints__list_element_comp_avatar">
                    <div class="complaints__list_element_comp_avatar_img" style="background: url(/img/users/<?=$user->image?>)"></div>
                    <p class="username"><?=$user->username?></p>
                </div>
                <p class="text"><?=$answers->text?></p>
            </div>
            <div class="complaints__list_element_btn">
                <?PHP IF(!$question->statusIsClosePay() && !$question->statusIsCloseNoPay()):?>
                    <a href="/questions/voting/<?=$answers->id_questions?>" class="question_btn"><?=Yii::t('app','Go questions')?></a>
                <?PHP ELSE:?>
                    <a class="question_btn"><?=Yii::t('app','Questions is closed')?></a>
                <?PHP ENDIF;?>
                <a href="/complaints/delete/<?=$complaints->id?>" class="delete_complain"><?=Yii::t('app','Delete complain')?></a>
                <a href="/answers/delete/?answer=<?=$answers->id?>&&complaints=<?=$complaints->id?>" class="delete_complain"><?=Yii::t('app','Delete answers')?></a>
            </div>
        </div>
    <?PHP ENDIF;?>
<?PHP ENDIF;?>