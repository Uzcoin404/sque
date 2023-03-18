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


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'text')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'coast')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app', 'Create and send moderation'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
