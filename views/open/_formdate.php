<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use mihaildev\ckeditor\CKEditor;
use yii\jui\DatePicker;
?>

<div class="create-form">

    <?php $form = ActiveForm::begin(
        [
            'enableClientValidation' => false
        ]
    ); ?>
   <?= $form->field($model, 'data')->textInput(['type' => 'date', 'maxlength' => true]); ?>
    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app', 'Create and send moderation'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
