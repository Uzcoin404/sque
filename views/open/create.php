<?php

use yii\helpers\Html;


$this->title = \Yii::t('app', 'Create new question');

?>
<div class="question_back__btn" style="left: 35px;"><a  href="javascript:history.back()"><?=\Yii::t('app','Back')?></a></div>
<div class="create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
