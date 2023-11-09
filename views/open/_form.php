<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use mihaildev\ckeditor\CKEditor;
use app\models\Price;

$price = Price::find()->one();
?>

<div class="create-form js-model" style="padding: 0.1em 2em;">

    <?php $form = ActiveForm::begin(
        [
            'enableClientValidation' => true
        ]
    ); ?>
    <?= $form->field($model, 'title', ['template' => "{label}\n{input}"])->textInput(['minlength' => 5,'maxlength' => 50])->input('title', ['placeholder' => "".Yii::t('app', 'Must contain at least 5 characters').""]) ?>
    <?= $form->field($model, 'text', ['template' => "{label}\n{input}"])->textArea(['minlength'=>200,'maxlength' => 2000])->textarea(['placeholder' => "".Yii::t('app', 'Must contain at least 200 characters').""])  ?>
    <?= $form->field($model, 'coast', ['template' => "{label}\n{input}"])->textInput(['maxlength' => true])->input('coast', ['placeholder' => "".Yii::t('app', 'The value of Cost for the best answer must be at least')." ".$price->money.""])  ?>
    <div class="form-group js-model">
        <p><?=Yii::t('app','* These fields must be filled in')?></p>
        <?= Html::submitButton(\Yii::t('app', 'Create and send moderation'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
