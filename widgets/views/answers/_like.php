<?php

use yii\helpers\Html;
use app\models\LikeAnswers;
use app\models\User;
use app\models\DislikeAnswer;
use app\models\Questions;
use app\models\ViewsAnswers;

$users=Yii::$app->user->identity; 

$status_questions = Questions::find()->where(["id"=>$answer->id_questions])->one();

$class_like = '';
$class_dislike = '';

?>

<?php



    if($users){
        if($status_questions->status == 6 || !isset($users)){
            $class_like = 'true';
            $class_dislike = 'true';
        }
           
        if($answer->id_user == $users->id){
            $class_dislike = 'true';
            $class_like = 'true';
        }
        $like_user=LikeAnswers::find()->where(["id_answer"=>$answer->id,"id_user"=>$users->id])->one();
        $dislike_user=DislikeAnswer::find()->where(["id_answer"=>$answer->id,"id_user"=>$users->id])->one();
        if($users->moderation==1 || !isset($users)){
            $class_like = 'true';
            $class_dislike = 'true';
        }

        if($like_user){
            $class_like = 'active';
         }
 
        if($dislike_user){
            $class_dislike = 'active';
        }
    } else {
        $class_like = 'true';
        $class_dislike = 'true';
    }
           

?>
        
    <?php if($status_questions->status == 6){ ?>
        <p class="like_answer"> 
            <button class="btn_like_answer block<?=$answer->id;?> <?=$class_like;?>" style="pointer-events: none !important;" onclick="SubmitLikeStatus(this)" data-id="<?=$answer->id;?>" data-like-status="0"></button>
            <?=Html::encode($answer->getLiks())?>
            <button class="btn_like_view block<?=$answer->id;?> open" onclick="UserBlockLike(this)" data-id="<?=$answer->id;?>"><?=Yii::t('app','Watch')?></button>
            <button class="btn_like_view block<?=$answer->id;?> close" onclick="UserBlockLikeClose(this)" style="display:none"><?=Yii::t('app','Close')?></button>
        </p>
        <p class="dislike_answer">
            <button class="btn_dislike_answer block<?=$answer->id;?> <?=$class_dislike?>" style="pointer-events: none !important;" onclick="SubmitDislikeStatus(this)" data-id="<?=$answer->id;?>" data-dislike-status="0"></button><?=Html::encode($answer->getDisliks());?>
            <button class="btn_dislike_view block<?=$answer->id;?> open" onclick="UserBlockDislike(this)" data-id="<?=$answer->id;?>"><?=Yii::t('app','Watch')?></button>
            <button class="btn_dislike_view block<?=$answer->id;?> close" onclick="UserBlockDislikeClose(this)" style="display:none"><?=Yii::t('app','Close')?></button>
        </p>
    <?php } elseif ($status_questions->status > 4 && $status_questions->status < 6) { ?>
        <?php if($users){ ?>
            <?php if($users->moderation){ ?>
                <p class="like_answer"> 
                    <button class="btn_like_answer block<?=$answer->id;?> <?=$class_like;?>" style="pointer-events: none !important;" onclick="SubmitLikeStatus(this)" data-id="<?=$answer->id;?>" data-like-status="0"></button>
                    <?=Html::encode($answer->getLiks())?>
                </p>
                <p class="dislike_answer">
                    <button class="btn_dislike_answer block<?=$answer->id;?> <?=$class_dislike?>" style="pointer-events: none !important;" onclick="SubmitDislikeStatus(this)" data-id="<?=$answer->id;?>" data-dislike-status="0"></button><?=Html::encode($answer->getDisliks());?>
                </p>
            <?php } else { ?>
                <p class="like_answer" style="padding-left:0">
                   <button class="btn_like_answer block<?=$answer->id;?> <?=$class_like;?>" style="position:unset" onclick="SubmitLikeStatus(this)" data-id="<?=$answer->id;?>" data-like-status="0"></button>
                </p>
                <p class="dislike_answer" style="padding-left:0">
                    <button class="btn_dislike_answer block<?=$answer->id;?> <?=$class_dislike?>" style="position:unset" onclick="SubmitDislikeStatus(this)" data-id="<?=$answer->id;?>" data-dislike-status="0"></button>
                </p>
            <?php } ?>
        <?php } ?>
    <?php } ?>