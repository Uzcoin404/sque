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
   <?= $form->field($model, 'data')->textInput(['type' => 'date', 'maxlength' => true, "min"=>date("Y-m-d",strtotime("+1 day")), 'max'=>date("Y-m-d",strtotime("+14 days"))]); ?>
    <div class="form-group">
    <?php if( Yii::$app->session->hasFlash('error') ): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('error'); ?>
        </div>
    <?php endif;?>
        <?= Html::submitButton(\Yii::t('app', 'Pay and send for moderation'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
