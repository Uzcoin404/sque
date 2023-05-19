<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use mihaildev\ckeditor\CKEditor;
?>

<div class="create-form">
    <h2><?=$question->title;?></h2>
    <p><?=$question->text;?></p>
    <?php $form = ActiveForm::begin(
        [
            'enableClientValidation' => true
        ]
    ); ?>

    <?= $form->field($model, 'text')->textArea(['maxlength' => 2000, 'minlength' => 200]) ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app', 'Create answer'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
