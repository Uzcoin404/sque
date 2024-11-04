<?php

$this->title = \Yii::t('app', 'Create new question');
$user = Yii::$app->user->identity;

if ($user): ?>
  <!-- <div class="question_back__btn" style="left: 35px;"><a  href="javascript:history.back()"><?= \Yii::t('app', 'Back') ?></a></div> -->

  <div class="create">

    <?= $this->render('_form', [
      'model' => $model,
    ]) ?>

  </div>
  <!-- <p style="margin: 60px 0px 0px 40px"><?= \Yii::t('app', 'Go to the Chat section and contact the Administrator') ?></p> -->

<?php else: ?>
  <div class="block_info_notauth">
    <p class="info"><?= Yii::t('app', 'Only authorized users can ask questions on the site, please Log in or Register!') ?></p>
  </div>
<?php endif ?>