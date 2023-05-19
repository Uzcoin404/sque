<?php

use yii\helpers\Html;


$this->title = \Yii::t('app', 'Change question');

?>
<div class="create">

    <?= $this->render('_form_update', [
        'model' => $model,
        'title' => $questions->title,
        'text' => $questions->text,
        'price' => $questions->coast,
    ]) ?>

</div>
