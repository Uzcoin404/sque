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
    <?= $form->field($model, 'title')->textInput(['minlength' => 30,'maxlength' => 80]) ?>
    <?= $form->field($model, 'text')->textArea(['minlength'=>200,'maxlength' => 2000]) ?>
    <?= $form->field($model, 'coast')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app', 'Create and send moderation'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
