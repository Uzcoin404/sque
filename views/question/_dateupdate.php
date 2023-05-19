<?php

use yii\helpers\Html;


$this->title = \Yii::t('app', 'Create new question');

?>
<div class="create">

    <?= $this->render('_formdate', [
        'model' => $model,
    ]) ?>

</div>
