<?php
use yii\helpers\Html;
use app\models\LikeAnswers;
use app\models\User;
use app\models\DislikeAnswer;
use app\models\Questions;

$class_like = '';
$class_dislike = '';

$status_questions = Questions::find()->where(["id"=>$answer->question_id])->one();

$user_img = User::find()->where(["id"=>$answer->user_id])->one();

$users=Yii::$app->user->identity;

if($answer->user_id == $status_questions->winner_id){
?>

<div class='answers_post__list_element winner' data-answer-id="<?=$answer->id;?>" data-status="0" data-id-question="<?=$question_id?>">
    <div class="title_info">
        <?PHP IF($orderWinner):?>
            <span class="answer_number__level">№<?=$answer->number;?></span>
        <?PHP ENDIF;?>
        <?php
        if($status_questions->status <= 5){
        ?>
            <img src="/img/img/status.png" loading="lazy">
        <?php
        } 
        ?>
        
    </div>
    <p class='text'>
        <?=$answer->GetText();?>
    </p>
    <a onclick="OpenFullText(this)" data-answer-id="<?=$answer->id;?>" class="opentext"><?=\Yii::t('app','Full text')?></a>
    <a onclick="CloseFullText(this)" data-answer-id="<?=$answer->id;?>" class="closetext"><?=\Yii::t('app','Close text')?></a>
    <div class='answers_post__list_element_text_price_full'>
        <?php
            if($status_questions->status > 4){
                
                if(!isset($user)){

                    $user=User::find()->all();
                
                    foreach($user as $info){
                        $like_user=LikeAnswers::find()->where(["id_answer"=>$answer->id,"user_id"=>$info->id])->one();
        
                        $dislike_user=DislikeAnswer::find()->where(["id_answer"=>$answer->id,"user_id"=>$info->id])->one();
                    }

                } else {

                    $like_user=LikeAnswers::find()->where(["id_answer"=>$answer->id,"user_id"=>$user->id])->one();
        
                    $dislike_user=DislikeAnswer::find()->where(["id_answer"=>$answer->id,"user_id"=>$user->id])->one();

                }

                if($status_questions->status == 6 || !isset($users)){

                    $class_like = 'active';
                    $class_dislike = 'active';

                } else {

                    if($like_user){
                        $class_like = 'active';
                    }

                    if($dislike_user){
                        $class_dislike = 'active';
                    }

                }
            

        ?>
                <p class="likes">
                    <button class="btn_like_answer block<?=$answer->id;?> <?=$class_like;?>" onclick="SubmitLikeStatus(this)" data-id="<?=$answer->id;?>" data-like-status="0"></button><?=Html::encode($answer->getLiks()).' '.\Yii::t('app','Like')?>
                </p>
                <p class="dislikes">
                    <button class="btn_dislike_answer block<?=$answer->id;?> <?=$class_dislike?>" onclick="SubmitDislikeStatus(this)" data-id="<?=$answer->id;?>" data-dislike-status="0"></button><?=Html::encode($answer->getDisliks()).' '.\Yii::t('app','Dislike');?>
                </p>
                <?php if($status_questions->status == 6) {?>
                    <p class="views">
                        <?=Html::encode($answer->getView()).' '.\Yii::t('app','Views');?>
                    </p>
                <?php } ?>
        <?php } ?>
    </div>
    
</div>
<?php
}

?>