<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;
use kartik\select2\Select2;
?>
<div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Создание заметки:</h5>
        <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
    <div class="modal-body">
        <div class="container form-modal__container">
            <div class="row form-modal__row">
            <?php $form = ActiveForm::begin(
                    [
                        'id'=>'create_note',
                        'options' => [
                            'class' => 'form-modal'
                          ],
                        'action' => '/notes/create',
                        'enableAjaxValidation' => false,
                        'validationUrl' => '/notes/validate',
                       ]
                ); ?>
                <div class="col-12">
                    <?= $form->field($model, 'name')->textInput(['class'=>'','maxlength' => true,'placeholder' => 'Название заметки'])->label(false) ?>
                </div>
                <div class="col-12">
                    <?= $form->field($model, 'type')->hiddenInput(['class'=>'','value' => $model->type])->label(false) ?>
                </div>
                <div class="col-12">
                    <?= $form->field($model, 'id_target')->hiddenInput(['class'=>'','value' => $model->id_target])->label(false) ?>
                </div>
                <div class="col-12">
                  
                    <?php 
                        echo Summernote::widget([
                        'language'=>'ru-RU',
                        'model' => $model,
                        'attribute' => 'text',
                        'enableCodeView' => true,
                        'enableHelp' => false,
                    ]);?>
                </div>
                <div class="col-12">
                        <?= $form->field($model, 'group',['inputOptions' => ['class'=>'','id' => 'update-model-id_group-'.$model->id]])->widget(Select2::classname(), [
                            'data' => $model->getGroupsList(),
                            'language' => 'ru',
                            'options' => [ 'multiple' => true, 'prompt' => '...','value'=>$model->id_group],
                            'pluginOptions' => [
                               // 'tags' => true,
                            ],
                            
                        ])->label();?>
                </div>
                <div class="col-12">
                    <div class="form-modal__footer">
                                <a OnClick="SaveNote('create_note',this);" class="btn form-modal__footer-btn">
                                  <i class="bi bi-save"></i>Сохранить
                                </a>
                                <button type="submit" class="btn form-modal__footer-btn">
                                  <i class="bi bi-box-arrow-in-left"></i>Сохранить и закрыть
                                </button>
                                <a OnClick="SaveNoteAndAdd('create_note',this);" class="btn form-modal__footer-btn">
                                  <i class="bi bi-arrow-repeat"></i>Сохранить и добавить
                                </a>
                              
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
                
