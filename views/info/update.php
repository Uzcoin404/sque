<?php

use yii\helpers\Html;


$this->title = \Yii::t('app', 'Update info');

?>
<div class="create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
