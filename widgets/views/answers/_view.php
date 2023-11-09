<?PHP 
use yii\helpers\Html;
use app\models\LikeAnswers;
use app\models\User;
use app\models\DislikeAnswer;
use app\models\Questions;
use app\models\ViewsAnswers;
use app\models\CloseAnswer;

$user_class = "";

$moderation = '';


$status_questions = Questions::find()->where(["id"=>$answer->id_questions])->one();

$user_img = User::find()->where(["id"=>$answer->id_user])->one();

$users=Yii::$app->user->identity;

if($users){
    if($users->id == $answer->id_user){
        $user_class = "my_answers";
    }
    $moderation = $users->moderation;
}


if($status_questions->status == 6){
?>

    <a name="top"></a>
    
    <?PHP IF($answer->number == 1):?>
        <div class='answers_post__list_element winner <?=$user_class?>' data-answer-id="<?=$answer->id;?>" data-status="0" data-id-question="<?=$id_questions?>" style="display:flex; align-items:center;">
    <?PHP ELSEIF($answer->number == 2):?>
        <div class='answers_post__list_element winner_two <?=$user_class?>' data-answer-id="<?=$answer->id;?>" data-status="0" data-id-question="<?=$id_questions?>" style="display:flex; align-items:center;">
    <?PHP ELSEIF($answer->number > 2):?>
        <div class='answers_post__list_element <?=$user_class?>' data-answer-id="<?=$answer->id;?>" data-status="0" data-id-question="<?=$id_questions?>" style="display:flex; align-items:center;">
    <?PHP ELSEIF($status_questions->status <= 5):?>
        <div class='answers_post__list_element <?=$user_class?>' data-answer-id="<?=$answer->id;?>" data-status="0" data-id-question="<?=$id_questions?>">
    <?PHP ENDIF;?>
    <?php if($users){ ?>
        <a name="<?=$answer->id_user?>"></a>
    <?php } ?>
    <?php
        $text_view = Yii::t('app','Full text');
        $class_view = ''; 
        $status_user = 0;  
        if($users){
            $view = ViewsAnswers::find()->where(['id_answer'=>$answer->id, 'id_user'=>$users->id])->one();
            $close = CloseAnswer::find()->where(['id_answer'=>$answer->id, 'id_user'=>$users->id])->one();
            if($view){
                if($view->button_click == 1){
                    $text_view = Yii::t('app','Show the whole text again');
                    $class_view = 'color_view';
                }
            }

            if($close){
                $text_view = Yii::t('app','Show the whole text again');
                $class_view = 'color_view';
            }
            $status_user = 1;
        }

    ?>
    <div class="title_info" style="margin: 0px; margin-right: 30px; align-self: flex-start; margin-top: 30px;">
            <?PHP IF($answer->number > 1):?>
                <span class="answer_number__level">№<?=$answer->number;?></span>
            <?PHP ENDIF;?>

            <?PHP IF($answer->number > 2):?>
                <div class="answers_post_list_element_button" data-id="<?=$answer->id_user?>" onclick="UserInfo(this, 0)">
                <?php
                if($status_questions->status <= 5){
                ?>
                    <img src="/img/img/status.png" loading="lazy" style="display:none">
                <?php
                } else {
                ?>
                    <!-- <img src="/img/users/<?=$user_img->image?>" loading="lazy"> -->
                <?php
                }
                ?>
                    <div class="ansers_post_list_element_user_info" data-id="<?=$answer->id_user?>">
                        <p class="date"><?=Yii::t('app','Date of registration')?>: <span></span></p>
                        <p class="question"><?=Yii::t('app','Asked questions')?>: <span></span></p>
                        <p class="answers"><?=Yii::t('app','Gave answers')?>: <span></span></p>
                        <p class="like"><?=Yii::t('app','Put Likes')?>: <span></span></p>
                        <p class="dislike"><?=Yii::t('app','Put dislikes')?>: <span></span></p>
                        <p class="action"><?=Yii::t('app','Last activity')?>: <span></span></p>
                    </div>
                </div>
            <?PHP ENDIF; ?>       
        </div>
    <div class="answers_info_text_block">
    <div class="answers_post__list_element_text_info">
    <!-- Архив вопросов и ответов -->
        <p class='text'>
            <?=$answer->GetText();?>
        </p>
        <div class="answers_post__list_element_text_info_btn">
            <?php if($status_questions->status == 6): ?>
                <a onclick="OpenFullTextClose(this)" data-answer-id="<?=$answer->id;?>" data-status-user="<?=$status_user?>" class="opentext <?=$class_view?>"><?=$text_view?></a>
            <?php else: ?>
                <a onclick="OpenFullText(this)" data-answer-id="<?=$answer->id;?>" data-status-user="<?=$status_user?>" class="opentext <?=$class_view?>"><?=$text_view?></a>
            <?php endif; ?>
                <a onclick="CloseFullText(this)" data-answer-id="<?=$answer->id;?>" class="closetext <?=$class_view?>"><?=\Yii::t('app','Close text')?></a>
        </div>
    </div>
            
    <?php
    $filter = 0;
    if($filter_status){
        $filter = 1;
    }
    
    ?>

<?php
// echo '<pre>'; 
// print_r($answer->number);
// echo '</pre>'; 

?>
    <div class='answers_post__list_element_text_price_full'>
            
                <?=Yii::$app->controller->renderPartial("//../widgets/views/answers/_like",["answer"=>$answer, "filter_status"=>$filter]);?>
             
                <?php if($status_questions->status == 6 || $moderation) {?>
                    <p class="views">
                        <?=Html::encode($answer->getView()).' '.\Yii::t('app','Views answer');?>
                    </p>
                <?php } ?>
                <?php if($status_questions->status == 5) {?>
                    <p class="complaints">
                        <a href="/complaints?id_user=<?=$answer->id_user?>&id_answers=<?=$answer->id?>&id_questions=<?=$answer->id_questions?>"><?=Yii::t('app','Complain')?></a>
                    </p>
                <?php } ?>
                <?PHP 
                    // IF($answer->number <= 2): тут было так
                ?> 
                <?PHP IF($answer->number):?>
                    <div class="answers_post_list_element_button" data-id="<?=$answer->id_user?>" onclick="UserInfo(this, 0)">
                    <?php
                    if($status_questions->status <= 5){
                    ?>
                        <img src="/img/img/status.png" loading="lazy" style="display:none">
                    <?php
                    } else {
                    ?>
                        <img src="/img/users/<?=$user_img->image?>" loading="lazy">
                    <?php
                    }
                    ?>
                        <div class="ansers_post_list_element_user_info" data-id="<?=$answer->id_user?>">
                            <p class="date"><?=Yii::t('app','Date of registration')?>: <span></span></p>
                            <p class="question"><?=Yii::t('app','Asked questions')?>: <span></span></p>
                            <p class="answers"><?=Yii::t('app','Gave answers')?>: <span></span></p>
                            <p class="like"><?=Yii::t('app','Put Likes')?>: <span></span></p>
                            <p class="dislike"><?=Yii::t('app','Put dislikes')?>: <span></span></p>
                            <p class="action"><?=Yii::t('app','Last activity')?>: <span></span></p>
                        </div>
                    </div>
                    <p class='title' style="margin-bottom: 0px !important;">
                        <?=$answer->GetUserName();?>
                    </p>   
                <?PHP ENDIF; ?>
        
    </div>
    <div class="user_block_like">
    </div> 
    </div>

    <div class="sroll_top" >
        <a href="#top"></a>
    </div>
</div>

<?
}


if($status_questions->status >= 4 && $status_questions->status != 6){
    
?>
  <a name="top"></a>
    <?PHP IF($answer->number == 1):?>
        <div class='answers_post__list_element winner <?=$user_class?>' data-answer-id="<?=$answer->id;?>" data-status="0" data-id-question="<?=$id_questions?>">
    <?PHP ELSEIF($answer->number == 2):?>
        <div class='answers_post__list_element winner_two <?=$user_class?>' data-answer-id="<?=$answer->id;?>" data-status="0" data-id-question="<?=$id_questions?>">
    <?PHP ELSEIF($answer->number > 2):?>
        <div class='answers_post__list_element <?=$user_class?>' data-answer-id="<?=$answer->id;?>" data-status="0" data-id-question="<?=$id_questions?>">
    <?PHP ELSEIF($status_questions->status <= 5):?>
        <div class='answers_post__list_element <?=$user_class?>' data-answer-id="<?=$answer->id;?>" data-status="0" data-id-question="<?=$id_questions?>">
    <?PHP ENDIF;?>
    <?php if($users){ ?>
        <a name="<?=$answer->id_user?>"></a>
    <?php } ?>
    <div class="title_info">
        <?PHP IF($orderWinner || $answer->number>0):?>
            <?PHP IF($answer->number > 2):?>
                <span class="answer_number__level">№<?=$answer->number;?></span>
            <?PHP ELSE:?>
            <?PHP ENDIF;?>
        <?PHP ENDIF;?>
            <div class="answers_post_list_element_button" data-id="<?=$answer->id_user?>" onclick="UserInfo(this, 0)">
            <?php
            if($status_questions->status <= 5){
            ?>
                <img src="/img/img/status.png" loading="lazy" style="display:none">
            <?php
            } else {
            ?>
                <img src="/img/users/<?=$user_img->image?>" loading="lazy">
            <?php
            }
            ?>
                <div class="ansers_post_list_element_user_info" data-id="<?=$answer->id_user?>">
                    <p class="date"><?=Yii::t('app','Date of registration')?>: <span></span></p>
                    <p class="question"><?=Yii::t('app','Asked questions')?>: <span></span></p>
                    <p class="answers"><?=Yii::t('app','Gave answers')?>: <span></span></p>
                    <p class="like"><?=Yii::t('app','Put Likes')?>: <span></span></p>
                    <p class="dislike"><?=Yii::t('app','Put dislikes')?>: <span></span></p>
                    <p class="action"><?=Yii::t('app','Last activity')?>: <span></span></p>
                </div>
            </div>

        <!-- <p class='title'>
            <?php /*$answer->GetUserName(); */?>
        </p>         -->
    </div>
    <?php
        $text_view = Yii::t('app','Full text');
        $class_view = ''; 
        $status_user = 0;  
        if($users){
            $view = ViewsAnswers::find()->where(['id_answer'=>$answer->id, 'id_user'=>$users->id])->one();
            $close = CloseAnswer::find()->where(['id_answer'=>$answer->id, 'id_user'=>$users->id])->one();
            if($view){
                if($view->button_click == 1){
                    $text_view = Yii::t('app','Show the whole text again');
                    $class_view = 'color_view';
                }
            }

            if($close){
                $text_view = Yii::t('app','Show the whole text again');
                $class_view = 'color_view';
            }
            $status_user = 1;
        }

    ?>
    <!-- КОГДА СТАТУС В ГОЛОСУЮТ ПО ОТВЕТАМ -->
    <div class="answers_post__list_element_text_info">
        <p class='text'>
            <?=$answer->GetText();?>
        </p>
        <div class="answers_post__list_element_text_info_btn" >
            <?php if($status_questions->status == 6){ ?>
                <a onclick="OpenFullTextClose(this)" data-answer-id="<?=$answer->id;?>" data-status-user="<?=$status_user?>" class="opentext <?=$class_view?>"><?=$text_view?></a>
            <?php } else { ?>
                <a onclick="OpenFullText(this)" data-answer-id="<?=$answer->id;?>" data-status-user="<?=$status_user?>" class="opentext <?=$class_view?>"><?=$text_view?></a>
            <?php } ?>
                <a onclick="CloseFullText(this)" data-answer-id="<?=$answer->id;?>" class="closetext <?=$class_view?>"><?=\Yii::t('app','Close text')?></a>
        </div>
    </div>
            
    <?php
    $filter = 0;
    if($filter_status){
        $filter = 1;
    }
    
    ?>

    <div class='answers_post__list_element_text_price_full'>

                <?=Yii::$app->controller->renderPartial("//../widgets/views/answers/_like",["answer"=>$answer, "filter_status"=>$filter]);?>
             
                <?php if($status_questions->status == 6 || $moderation) {?>
                    <p class="views">
                        <?=Html::encode($answer->getView()).' '.\Yii::t('app','Views answer');?>
                    </p>
                <?php } ?>
                <?php if($status_questions->status == 5) {?>
                    <p class="complaints">
                        <a href="/complaints?id_user=<?=$answer->id_user?>&id_answers=<?=$answer->id?>&id_questions=<?=$answer->id_questions?>"><?=Yii::t('app','Complain')?></a>
                    </p>
                <?php } ?>
        
    </div>
    <div class="user_block_like">
    </div>
    <div class="sroll_top" >
        <a href="#top"></a>
    </div>
</div>
<?php } ?>
