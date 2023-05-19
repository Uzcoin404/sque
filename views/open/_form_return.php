<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use mihaildev\ckeditor\CKEditor;
?>

<div class="create-form">

    <?php $form = ActiveForm::begin(
        [
            'enableClientValidation' => true
        ]
    ); ?>
    <?= $form->field($model, 'text_return')->textArea(['minlength'=>100,'maxlength' => 2000]) ?>
    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app', 'Return'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
