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
    <?= $form->field($model, 'text')->textArea(['minlength'=>0,'maxlength' => 2000,'placeholder'=> "".\Yii::t('app','To write text').""]) ?>
    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app', 'Send'), ['class' => 'btn_chat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
