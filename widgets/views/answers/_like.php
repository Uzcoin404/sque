<?php

use yii\helpers\Html;
use app\models\LikeAnswers;
use app\models\User;
use app\models\DislikeAnswer;
use app\models\Questions;
use app\models\ViewsAnswers;

$users=Yii::$app->user->identity; 

$status_questions = Questions::find()->where(["id"=>$answer->question_id])->one();

$class_like = '';
$class_dislike = '';
$class_sort = '';
$class_sort_dis = '';

?>

<?php



    if($users){
        if($status_questions->status == 6 || !isset($users)){
            $class_like = 'true';
            $class_dislike = 'true';
        }
           
        if($answer->user_id == $users->id){
            $class_dislike = 'true';
            $class_like = 'true';
        }
        $like_user=LikeAnswers::find()->where(["id_answer"=>$answer->id,"user_id"=>$users->id])->one();
        $dislike_user=DislikeAnswer::find()->where(["id_answer"=>$answer->id,"user_id"=>$users->id])->one();
        if($users->moderation==1 || !isset($users)){
            $class_like = 'true';
            $class_dislike = 'true';
        }

        if($status_questions->status == 5){
            if($like_user){
                $class_like = 'active';
             }
     
            if($dislike_user){
                $class_dislike = 'active';
            }
        }

    } else {
        $class_like = 'true';
        $class_dislike = 'true';
    }
       
    if($filter_status == 0 && $answer->getLiks() > 0){
        $class_sort = 'active';
    }

    if($filter_status > 0 && $answer->getDisliks() >0){
        $class_sort_dis = 'active';
    }

?>
        
    <?php if($status_questions->status == 6){ ?>
        <p class="likes"> 
            <button class="btn_like_answer status_close block<?=$answer->id;?> <?=$class_like;?> <?=$class_sort?>" style="pointer-events: none !important;" onclick="SubmitLikeStatus(this)" data-id="<?=$answer->id;?>" data-like-status="0" data-col="<?=$answer->getLiks()?>"></button>
            <?=Html::encode($answer->getLiks())?>
            <button class="btn_like_view block<?=$answer->id;?> open" onclick="UserBlockLike(this)" data-id="<?=$answer->id;?>"><?=Yii::t('app','Watch')?></button>
            <button class="btn_like_view block<?=$answer->id;?> close" onclick="UserBlockLikeClose(this)" style="display:none"><?=Yii::t('app','Close')?></button>
        </p>
        <p class="dislikes">
            <button class="btn_dislike_answer status_close block<?=$answer->id;?> <?=$class_dislike?> <?=$class_sort_dis?>" style="pointer-events: none !important;" onclick="SubmitDislikeStatus(this)" data-id="<?=$answer->id;?>" data-dislike-status="0"></button>
            <?php 
                // echo "<pre>";
                // print_r($answer);
                // echo "</pre>";
            ?>
            <?=Html::encode($answer->getDisliks());?>
            <button class="btn_dislike_view block<?=$answer->id;?> open" onclick="UserBlockDislike(this)" data-id="<?=$answer->id;?>"><?=Yii::t('app','Watch')?></button>
            <button class="btn_dislike_view block<?=$answer->id;?> close" onclick="UserBlockDislikeClose(this)" style="display:none"><?=Yii::t('app','Close')?></button>
        </p>
    <?php } elseif ($status_questions->status > 4 && $status_questions->status < 6) { ?>
        <?php if($users){ ?>
            <?php if($users->moderation){ ?>
                <p class="likes"> 
                    <button class="btn_like_answer block<?=$answer->id;?> <?=$class_like;?>" style="pointer-events: none !important;" onclick="SubmitLikeStatus(this)" data-id="<?=$answer->id;?>" data-like-status="0"></button>
                    <?=Html::encode($answer->getLiks())?>
                </p>
                <p class="dislikes">
                    <button class="btn_dislike_answer block<?=$answer->id;?> <?=$class_dislike?>" style="pointer-events: none !important;" onclick="SubmitDislikeStatus(this)" data-id="<?=$answer->id;?>" data-dislike-status="0"></button><?=Html::encode($answer->getDisliks());?>
                </p>
            <?php } else { ?>
                <p class="likes" style="padding-left:0">
                   <button class="btn_like_answer block<?=$answer->id;?> <?=$class_like;?>" style="position:unset" onclick="SubmitLikeStatus(this)" data-id="<?=$answer->id;?>" data-like-status="0"></button>
                </p>
                <p class="dislikes" style="padding-left:0">
                    <button class="btn_dislike_answer block<?=$answer->id;?> <?=$class_dislike?>" style="position:unset" onclick="SubmitDislikeStatus(this)" data-id="<?=$answer->id;?>" data-dislike-status="0"></button>
                </p>
            <?php } ?>
        <?php } else {
            ?>
                <p class="likes" style="padding-left:0">
                   <button class="btn_like_answer block<?=$answer->id;?> <?=$class_like;?>" style="position:unset; pointer-events: none !important;" onclick="SubmitLikeStatus(this)" data-id="<?=$answer->id;?>" data-like-status="0"></button>
                </p>
                <p class="dislikes" style="padding-left:0">
                    <button class="btn_dislike_answer block<?=$answer->id;?> <?=$class_dislike?>" style="position:unset; pointer-events: none !important;" onclick="SubmitDislikeStatus(this)" data-id="<?=$answer->id;?>" data-dislike-status="0"></button>
                </p>
            <?php
        } ?>
    <?php } ?>