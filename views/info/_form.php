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
    <?= $form->field($model, 'text_ru')->textArea(['minlength' => 5,'maxlength' => 200, 'value' => $model->text_ru]) ?>
    <?= $form->field($model, 'text_eng')->textArea(['minlength'=> 5,'maxlength' => 200, 'value' => $model->text_eng]) ?>
    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
