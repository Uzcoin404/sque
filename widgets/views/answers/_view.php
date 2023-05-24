<?PHP 
use yii\helpers\Html;
use app\models\LikeAnswers;
use app\models\User;
use app\models\DislikeAnswer;
use app\models\Questions;
use app\models\ViewsAnswers;

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


if($status_questions->status >= 4){
    
?>
  <a name="top"></a>
<?PHP IF($answer->id_user == $status_questions->winner_id):?>
    <div class='answers_post__list_element winner <?=$user_class?>' data-answer-id="<?=$answer->id;?>" data-status="0" data-id-question="<?=$id_questions?>">
<?PHP ELSE:?>
    <div class='answers_post__list_element <?=$user_class?>' data-answer-id="<?=$answer->id;?>" data-status="0" data-id-question="<?=$id_questions?>">
<?PHP ENDIF;?>
    <div class="title_info">
        <?PHP IF($orderWinner || $answer->number>0):?>
            <span class="answer_number__level">№<?=$answer->number;?></span>
        <?PHP ENDIF;?>
        <?php
        if($status_questions->status <= 5){
        ?>
            <img src="/img/img/status.png" loading="lazy" style="display:none">
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
        <?php
        if($users){
            if($status_questions->status == 4 && $answer->id_user == $users->id){
        ?>
            <p class="title"><?=$answer->GetUserName();?></p>
        <?php
            } 
        } 
        ?>
    </div>
    <?php if($users){ ?>
        <a name="<?=$answer->id_user?>"></a>
    <?php } ?>
    <?php
        $text_view = Yii::t('app','Full text');
        $class_view = ''; 
        $status_user = 0;  
        if($users){
            $view = ViewsAnswers::find()->where(['id_answer'=>$answer->id, 'id_user'=>$users->id])->one();

            if($view){
                $text_view = Yii::t('app','Show the whole text again');
                $class_view = 'color_view';
            }
            $status_user = 1;
        }

    ?>

    <div class="answers_post__list_element_text_info">
        <p class='text'>
            <?=$answer->GetText();?>
        </p>
        <div class="answers_post__list_element_text_info_btn">
            <a onclick="OpenFullText(this)" data-answer-id="<?=$answer->id;?>" data-status-user="<?=$status_user?>" class="opentext <?=$class_view?>"><?=$text_view?></a>
            <a onclick="CloseFullText(this)" data-answer-id="<?=$answer->id;?>" class="closetext <?=$class_view?>"><?=\Yii::t('app','Close text')?></a>
        </div>
    </div>


    <div class='answers_post__list_element_text_price_full'>

                <?=Yii::$app->controller->renderPartial("//../widgets/views/answers/_like",["answer"=>$answer]);?>
             
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
