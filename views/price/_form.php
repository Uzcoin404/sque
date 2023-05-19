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
    <?= $form->field($model, 'money')->textInput(['maxlength' => true, 'value' => $model->money]) ?>
    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app', 'Price changes'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
