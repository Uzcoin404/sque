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

    <?= $form->field($model, 'text', ['template' => "{label}\n{input}"])->textArea(['maxlength' => 2000, 'minlength' => 35])->textarea(['placeholder' => "".Yii::t('app', 'Must contain at least 35 characters').""]) ?>

    <div class="form-group">
        <p style="display: none;"><?=Yii::t('app','* These fields must be filled in')?></p>
        <?= Html::submitButton(\Yii::t('app', 'Create answer'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
