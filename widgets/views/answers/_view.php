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


$status_questions = Questions::find()->where(["id" => $answer->question_id])->one();

$user_img = User::find()->where(["id" => $answer->user_id])->one();

$users = Yii::$app->user->identity;

if ($users) {
    if ($users->id == $answer->user_id) {
        $user_class = "my_answers";
    }
    $moderation = $users->moderation;
}

if ($status_questions->status >= 4 && $status_questions->status != 6): ?>
    <a name="top"></a>
    <!-- <?PHP if ($answer->rank == 1): ?>
        <div class='answers_post__list_element winner <?= $user_class ?>' data-answer-id="<?= $answer->id; ?>" data-status="0" data-id-question="<?= $question_id ?>">
    <?PHP elseif ($answer->rank == 2): ?>
        <div class='answers_post__list_element winner_two <?= $user_class ?>' data-answer-id="<?= $answer->id; ?>" data-status="0" data-id-question="<?= $question_id ?>">
    <?PHP elseif ($answer->rank > 2): ?>
        <div class='answers_post__list_element <?= $user_class ?>' data-answer-id="<?= $answer->id; ?>" data-status="0" data-id-question="<?= $question_id ?>">
    <?PHP elseif ($status_questions->status <= 5): ?>
        <div class='answers_post__list_element <?= $user_class ?>' data-answer-id="<?= $answer->id; ?>" data-status="0" data-id-question="<?= $question_id ?>">
    <?PHP endif; ?> -->
    <div class='answers_post__list_element <?= $user_class ?>' data-answer-id="<?= $answer->id; ?>" data-status="0" data-id-question="<?= $question_id ?>">
        <?php if ($users): ?>
            <a name="<?= $answer->user_id ?>"></a>
        <?php endif ?>
        <div class="title_info">
            <?PHP if ($orderWinner || $answer->rank > 0): ?>
                <?PHP if ($answer->rank > 2): ?>
                    <span class="answer_number__level">№<?= $answer->rank; ?></span>
                <?PHP endif; ?>
            <?PHP endif; ?>

            <div class="answers_post_list_element_button" data-id="<?= $answer->user_id ?>" onclick="UserInfo(this, 0)">

                <?php if ($status_questions->status <= 5): ?>
                    <img src="/img/img/status.png" loading="lazy">
                <?php endif ?>

                <div class="ansers_post_list_element_user_info" data-id="<?= $answer->user_id ?>">
                    <p class="date"><?= Yii::t('app', 'Date of registration') ?>: <span></span></p>
                    <p class="question"><?= Yii::t('app', 'Asked questions') ?>: <span></span></p>
                    <p class="answers"><?= Yii::t('app', 'Gave answers') ?>: <span></span></p>
                    <p class="like"><?= Yii::t('app', 'Put Likes') ?>: <span></span></p>
                    <p class="dislike"><?= Yii::t('app', 'Put dislikes') ?>: <span></span></p>
                    <p class="action"><?= Yii::t('app', 'Last activity') ?>: <span></span></p>
                </div>
            </div>
        </div>
        <?php
        $text_view = Yii::t('app', 'Full text');
        $class_view = '';
        $status_user = 1;
        if ($users) {
            $view = ViewsAnswers::find()->where(['answer_id' => $answer->id, 'user_id' => $users->id])->one();
            // $close = CloseAnswer::find()->where(['answer_id'=>$answer->id, 'user_id'=>$users->id])->one();
            if ($view) {
                if ($view->button_click == 1) {
                    $text_view = Yii::t('app', 'Show the whole text again');
                    $class_view = 'color_view';
                }
            }

            // if($close){
            //     $text_view = Yii::t('app','Show the whole text again');
            //     $class_view = 'color_view';
            // }
            // $status_user = 1;
        }

        ?>
        <!-- КОГДА СТАТУС В ГОЛОСУЮТ ПО ОТВЕТАМ -->
        <div class="answers_post__list_element_text_info">
            <p class='text'>
                <?= $answer->GetText(); ?>
            </p>
            <div class="answers_post__list_element_text_info_btn">
                <?php if ($status_questions->status == 6) { ?>
                    <a onclick="OpenFullTextClose(this)" data-answer-id="<?= $answer->id; ?>" data-status-user="<?= $status_user ?>" class="opentext <?= $class_view ?>"><?= $text_view ?></a>
                <?php } else { ?>
                    <a onclick="OpenFullText(this)" data-answer-id="<?= $answer->id; ?>" data-status-user="<?= $status_user ?>" class="opentext <?= $class_view ?>"><?= $text_view ?></a>
                <?php } ?>
                <a onclick="CloseFullText(this)" data-answer-id="<?= $answer->id; ?>" class="closetext <?= $class_view ?>"><?= \Yii::t('app', 'Close text') ?></a>
            </div>
        </div>

        <?php
        $filter = 0;
        if ($filter_status) {
            $filter = 1;
        }
        ?>

        <div class='answers_post__list_element_text_price_full'>

            <?= Yii::$app->controller->renderPartial("//../widgets/views/answers/_like", ["answer" => $answer, "filter_status" => $filter]); ?>

            <?php if ($status_questions->status == 6 || $moderation): ?>
                <p class="views">
                    <?= Html::encode($answer->getView()) . ' ' . \Yii::t('app', 'Views answer'); ?>
                </p>
            <?php endif ?>
            <?php if ($status_questions->status == 5) { ?>
                <p class="complaints">
                    <a href="/complaints?user_id=<?= $answer->user_id ?>&answer_id=<?= $answer->id ?>&question_id=<?= $answer->question_id ?>"><?= Yii::t('app', 'Complain') ?></a>
                </p>
            <?php } ?>

        </div>
        <div class="user_block_like">
        </div>
        <div class="sroll_top">
            <a href="#top"></a>
        </div>
    </div>


<?php elseif ($status_questions->status == 6):
    $winner = $answer->winner == 1; ?>

    <a name="top"></a>
    <div class='answers_post__list_element <?= $winner ? 'winner' : '' ?> <?= $user_class ?>' data-answer-id="<?= $answer->id; ?>" data-status="0" data-id-question="<?= $question_id ?>" style="display:flex; align-items:center;">

        <?php if ($users): ?>
            <a name="<?= $answer->user_id ?>"></a>
        <?php endif ?>
        <?php
        $text_view = Yii::t('app', 'Full text');
        $class_view = '';
        $status_user = 0;
        $filter = 0;
        if ($filter_status) {
            $filter = 1;
        }
        // if($users){
        //     $view = ViewsAnswers::find()->where(['answer_id'=>$answer->id, 'user_id'=>$users->id])->one();
        //     $close = CloseAnswer::find()->where(['answer_id'=>$answer->id, 'user_id'=>$users->id])->one();
        //     if($view){
        //         if($view->button_click == 1){
        //             $text_view = Yii::t('app','Show the whole text again');
        //             $class_view = 'color_view';
        //         }
        //     }

        //     if($close){
        //         $text_view = Yii::t('app','Show the whole text again');
        //         $class_view = 'color_view';
        //     }
        //     $status_user = 1;
        // }
        ?>
        <div class="title_info" style="margin: 0px; margin-right: 30px; align-self: flex-start; margin-top: 30px;">
            <?PHP if ($answer->rank != 1): ?>
                <span class="answer_number__level">№<?= $answer->rank ?></span>
            <?PHP endif; ?>

            <?PHP if ($answer->rank >= 2): ?>
                <div class="answers_post_list_element_button" data-id="<?= $answer->user_id ?>" onclick="UserInfo(this, 0)">
                    <div class="ansers_post_list_element_user_info" data-id="<?= $answer->user_id ?>">
                        <p class="date"><?= Yii::t('app', 'Date of registration') ?>: <span></span></p>
                        <p class="question"><?= Yii::t('app', 'Asked questions') ?>: <span></span></p>
                        <p class="answers"><?= Yii::t('app', 'Gave answers') ?>: <span></span></p>
                        <p class="like"><?= Yii::t('app', 'Put Likes') ?>: <span></span></p>
                        <p class="dislike"><?= Yii::t('app', 'Put dislikes') ?>: <span></span></p>
                        <p class="action"><?= Yii::t('app', 'Last activity') ?>: <span></span></p>
                    </div>
                </div>
            <?PHP endif; ?>
        </div>
        <div class="answers_info_text_block">
            <div class="answers_post__list_element_text_info">
                <!-- Архив вопросов и ответов -->
                <p class='text'>
                    <?= $answer->GetText(); ?>
                </p>
                <div class="answers_post__list_element_text_info_btn">
                    <a onclick="OpenFullTextClose(this)" data-answer-id="<?= $answer->id; ?>" data-status-user="<?= $status_user ?>" class="opentext <?= $class_view ?>"><?= $text_view ?></a>
                    <a onclick="CloseFullText(this)" data-answer-id="<?= $answer->id; ?>" class="closetext <?= $class_view ?>"><?= \Yii::t('app', 'Close text') ?></a>
                </div>
            </div>

            <div class='answers_post__list_element_text_price_full'>
                <?= Yii::$app->controller->renderPartial("//../widgets/views/answers/_like", ["answer" => $answer, "filter_status" => $filter]); ?>
                <p class="views">
                    <?= Html::encode($answer->getView()) . ' ' . \Yii::t('app', 'Views answer'); ?>
                </p>

                <?PHP
                // IF($answer->rank <= 2): тут было так

                if ($answer->winner == 1): ?>
                    <div class="answers_post_list_element_button" data-id="<?= $answer->user_id ?>" onclick="UserInfo(this, 0)">
                        <div class="ansers_post_list_element_user_info" data-id="<?= $answer->user_id ?>">
                            <p class="date"><?= Yii::t('app', 'Date of registration') ?>: <span></span></p>
                            <p class="question"><?= Yii::t('app', 'Asked questions') ?>: <span></span></p>
                            <p class="answers"><?= Yii::t('app', 'Gave answers') ?>: <span></span></p>
                            <p class="like"><?= Yii::t('app', 'Put Likes') ?>: <span></span></p>
                            <p class="dislike"><?= Yii::t('app', 'Put dislikes') ?>: <span></span></p>
                            <p class="action"><?= Yii::t('app', 'Last activity') ?>: <span></span></p>
                        </div>
                    </div>
                    <p class='title d-flex' style="margin-bottom: 0px !important;" data-id="<?= $answer->user_id ?>" onclick="UserInfo(this, 0)">
                        <?= $answer->GetUserName() ?>
                        <svg class="my-auto ms-3 me-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 250 250" version="1.1">
                            <g id="surface1">
                                <path style=" stroke:none;fill-rule:nonzero;fill:rgb(32.549021%,68.235296%,58.039218%);fill-opacity:1;" d="M 125 0 C 194.03125 0 250 55.96875 250 125 C 250 194.03125 194.03125 250 125 250 C 55.96875 250 0 194.046875 0 125 C 0 55.953125 55.960938 0 125 0 " />
                                <path style=" stroke:none;fill-rule:nonzero;fill:rgb(100%,100%,100%);fill-opacity:1;" d="M 140.425781 108.34375 L 140.425781 89.75 L 182.949219 89.75 L 182.949219 61.417969 L 67.160156 61.417969 L 67.160156 89.75 L 109.6875 89.75 L 109.6875 108.328125 C 75.125 109.917969 49.136719 116.761719 49.136719 124.960938 C 49.136719 133.164062 75.136719 140.007812 109.6875 141.605469 L 109.6875 201.167969 L 140.4375 201.167969 L 140.4375 141.601562 C 174.9375 140.007812 200.871094 133.167969 200.871094 124.976562 C 200.871094 116.78125 174.9375 109.941406 140.4375 108.351562 M 140.4375 136.554688 L 140.4375 136.539062 C 139.570312 136.59375 135.113281 136.863281 125.1875 136.863281 C 117.253906 136.863281 111.671875 136.636719 109.703125 136.535156 L 109.703125 136.558594 C 79.167969 135.207031 56.375 129.890625 56.375 123.527344 C 56.375 117.164062 79.171875 111.855469 109.703125 110.5 L 109.703125 131.261719 C 111.703125 131.398438 117.421875 131.738281 125.316406 131.738281 C 134.800781 131.738281 139.566406 131.34375 140.441406 131.261719 L 140.441406 110.5 C 170.917969 111.859375 193.65625 117.179688 193.65625 123.519531 C 193.65625 129.859375 170.90625 135.183594 140.441406 136.542969 " />
                            </g>
                        </svg>
                        <?= $answer->reward ?>
                    </p>
                <?PHP endif; ?>
            </div>
            <div class="user_block_like"></div>
        </div>

        <div class="sroll_top">
            <a href="#top"></a>
        </div>
    </div>
<?php endif ?>