<?php

use yii\helpers\Html;


$this->title = \Yii::t('app', 'Reason for return');

?>
<div class="create">

    <?= $this->render('_form_return', [
        'model' => $model,
    ]) ?>

</div>
