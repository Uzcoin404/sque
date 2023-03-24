<?php

use yii\helpers\Html;


$this->title = \Yii::t('app', 'Create answer');

?>
<div class="create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
