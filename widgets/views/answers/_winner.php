<?php
use yii\helpers\Html;
use app\models\LikeAnswers;
use app\models\User;
use app\models\DislikeAnswer;
use app\models\Questions;

$class_like = '';
$class_dislike = '';

$status_questions = Questions::find()->where(["id"=>$answer->id_questions])->one();

$user_img = User::find()->where(["id"=>$answer->id_user])->one();

$users=Yii::$app->user->identity;

if($answer->id_user == $status_questions->winner_id){
?>

<div class='answers_post__list_element winner' data-answer-id="<?=$answer->id;?>" data-status="0" data-id-question="<?=$id_questions?>">
    <div class="title_info">
        <?PHP IF($orderWinner):?>
            <span class="answer_number__level">№<?=$answer->number;?></span>
        <?PHP ENDIF;?>
        <?php
        if($status_questions->status <= 5){
        ?>
            <img src="/img/img/status.png" loading="lazy">
        <?php
        } else {
        ?>
            <img src="/img/users/<?=$user_img->image?>" loading="lazy">
            <p class='title'>
                <?=$answer->GetUserName();?>
            </p>
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
                        $like_user=LikeAnswers::find()->where(["id_answer"=>$answer->id,"id_user"=>$info->id])->one();
        
                        $dislike_user=DislikeAnswer::find()->where(["id_answer"=>$answer->id,"id_user"=>$info->id])->one();
                    }

                } else {

                    $like_user=LikeAnswers::find()->where(["id_answer"=>$answer->id,"id_user"=>$user->id])->one();
        
                    $dislike_user=DislikeAnswer::find()->where(["id_answer"=>$answer->id,"id_user"=>$user->id])->one();

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
                <p class="like_answer">
                    <button class="btn_like_answer block<?=$answer->id;?> <?=$class_like;?>" onclick="SubmitLikeStatus(this)" data-id="<?=$answer->id;?>" data-like-status="0"></button><?=Html::encode($answer->getLiks()).' '.\Yii::t('app','Like')?>
                </p>
                <p class="dislike_answer">
                    <button class="btn_dislike_answer block<?=$answer->id;?> <?=$class_dislike?>" onclick="SubmitDislikeStatus(this)" data-id="<?=$answer->id;?>" data-dislike-status="0"></button><?=Html::encode($answer->getDisliks()).' '.\Yii::t('app','Dislike');?>
                </p>
                <p class="views">
                    <?=Html::encode($answer->getView()).' '.\Yii::t('app','Views');?>
                </p>
        <?php } ?>
    </div>
    
</div>
<?php
}

?>