<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
    $this->title = \Yii::t('app', 'Read'); 
?>
<div class='read'>
    <div class='read__list '>
        <div class="read__list_element list">
            <div class="list_element">
                <h4><?=\Yii::t('app', 'Read Terms of Use');?></h4>
                    <?php $form = ActiveForm::begin(
                        [
                            'enableClientValidation' => true
                        ]
                    ); ?>
                        <?= $form->field($Docs, 'file', ['template' => "{label}\n{input}"])->fileInput([]) ?>
                        <?= $form->field($Docs, 'href')->hiddenInput(['value'=>'term']) ?>
                        <div class="form-group js-model">
                            
                            <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
            </div>
        
            <div class="list_element">
                <h4><?=\Yii::t('app', 'Read Privacy Policy');?></h4>
                    <?php $form = ActiveForm::begin(
                        [
                            'enableClientValidation' => true
                        ]
                    ); ?>
                        <?= $form->field($Docs, 'file', ['template' => "{label}\n{input}"])->fileInput([]) ?>
                        <?= $form->field($Docs, 'href', ['template' => "{label}\n{input}"])->hiddenInput(['value'=>'privacy']) ?>
                        <div class="form-group js-model">
                 
                            <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
            </div>
            <div class="list_element">
                <h4><?=\Yii::t('app', 'Disclaimer for registered users');?></h4>
                    <?php $form = ActiveForm::begin(
                        [
                            'enableClientValidation' => true
                        ]
                    ); ?>
                        <?= $form->field($Docs, 'file', ['template' => "{label}\n{input}"])->fileInput([]) ?>
                        <?= $form->field($Docs, 'href')->hiddenInput(['value'=>'register']) ?>
                        <div class="form-group js-model">
                       
                            <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
            </div>
            <div class="list_element">
                <h4><?=\Yii::t('app', 'Disclaimer for Unregistered Users');?></h4>
                    <?php $form = ActiveForm::begin(
                        [
                            'enableClientValidation' => true
                        ]
                    ); ?>
                        <?= $form->field($Docs, 'file', ['template' => "{label}\n{input}"])->fileInput([]) ?>
                        <?= $form->field($Docs, 'href', ['template' => "{label}\n{input}"])->hiddenInput(['value'=>'unregister']) ?>
                        <div class="form-group js-model">
                        
                            <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
            </div>
            <div class="list_element">
                <h4><?=\Yii::t('app', 'Cookie Policy');?></h4>
                    <?php $form = ActiveForm::begin(
                        [
                            'enableClientValidation' => true
                        ]
                    ); ?>
                        <?= $form->field($Docs, 'file', ['template' => "{label}\n{input}"])->fileInput([]) ?>
                        <?= $form->field($Docs, 'href', ['template' => "{label}\n{input}"])->hiddenInput(['value'=>'cookie']) ?>
                        <div class="form-group js-model">
                        
                            <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
            </div>
            <div class="list_element">
                <h4><?=\Yii::t('app', 'Pop-up Title');?></h4>
                    <?php $form = ActiveForm::begin(
                        [
                            'enableClientValidation' => true
                        ]
                    ); ?>
                        <?= $form->field($Docs, 'text', ['template' => "{label}\n{input}"])->Input([]) ?>
                        <?= $form->field($Docs, 'href', ['template' => "{label}\n{input}"])->hiddenInput(['value'=>'popup_title']) ?>
                        <div class="form-group js-model">
                        
                            <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
            </div>
            <div class="list_element">
                <h4><?=\Yii::t('app', 'Pop-up text');?></h4>
                    <?php $form = ActiveForm::begin(
                        [
                            'enableClientValidation' => true
                        ]
                    ); ?>
                        <?= $form->field($Docs, 'file', ['template' => "{label}\n{input}"])->fileInput([]) ?>
                        <?= $form->field($Docs, 'href', ['template' => "{label}\n{input}"])->hiddenInput(['value'=>'popup_text']) ?>
                        <div class="form-group js-model">
                        
                            <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>