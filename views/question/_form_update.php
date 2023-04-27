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
    <?= $form->field($model, 'title')->textInput(['minlength' => 5,'maxlength' => 50, 'value' => $title]) ?>
    <?= $form->field($model, 'text')->textArea(['minlength'=>200,'maxlength' => 2000, 'value' => $text]) ?>
    <?= $form->field($model, 'coast')->textInput(['maxlength' => true, 'value' => $price]) ?>
    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app', 'Change and send moderation'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
