<?php

use yii\helpers\Html;


$this->title = \Yii::t('app', 'Price change');

?>
<div class="create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
