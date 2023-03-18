<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;
use kartik\select2\Select2
?>
<div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Сюжет книги: <?=$model->name;?></h5>
        <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
  <div class="modal-body">
               
                  <div class="tab">
                        <ul class="nav nav-tabs">
                          <li class="nav-item ">
                              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#main_<?=$model->id;?>">Основная информация</button>
                          </li>
                        
                          <li class="nav-item">
                              <button class="nav-link" data-bs-toggle="tab"  data-bs-target="#note<?=$model->id;?>">Заметки</button>
                          </li>
                        </ul>
                        <div class="tab-content">
                          <div class="tab-pane fade active show" id="main_<?=$model->id;?>">
                          <?php $form = ActiveForm::begin(
                                [
                                    'id'=>'m_f_book',
                                    'options' => [
                                      'class' => 'form-modal'
                                    ],
                                    'action' => '/books/ajx/getactivestory',
                                    'enableAjaxValidation' => false,
                                    'validationUrl' => '/books/validate',
                                  ]
                            ); ?>
                            <div class="container form-modal__container">
                                <div class="row form-modal__row">
                                  <div class="col-12">
                                        <?= $form->field($model, 'name')->textarea(['class'=>'','maxlength' => true,'placeholder' => ''])->label() ?>
                                  </div>
                                  <div class="col-12">
                                        <?= $form->field($model, 'genre')->textarea(['class'=>'','maxlength' => true,'placeholder' => ''])->label() ?>
                                  </div>
                                  <div class="col-12">
                                    <?= $form->field($model, 'plan')->textarea(['class'=>'','row' => 9])->label() ?>    

                                  </div>
                                  <div class="col-12">
                                    <?= $form->field($model, 'annotation')->textarea(['class'=>'','row' => 9])->label() ?>    
                                  </div>
                                  <div class="col-12">
                                      <?= $form->field($model, 'mainpers')->textarea(['class'=>'','maxlength' => true,'placeholder' => ''])->label() ?>
                                  </div>
                                  <div class="col-12">   
                                    <?= $form->field($model, 'situation')->textarea(['class'=>'','row' => 9])->label() ?> 
                                  </div>
                                  <div class="col-12">    
                                    <?= $form->field($model, 'target')->textarea(['class'=>'','row' => 9])->label() ?>        
                                  </div>
                                  <div class="col-12">
                                    <?= $form->field($model, 'conflict')->textarea(['class'=>'','row' => 9])->label() ?> 
                                  </div>
                                  <div class="col-12">
                                  <?= $form->field($model, 'crisis')->textarea(['class'=>'','row' => 9])->label() ?>   
                                  </div>
                                  <div class="col-12">
                                    <?= $form->field($model, 'ex_synopsis')->textarea(['class'=>'','row' => 9])->label() ?> 
                                  </div>   
                              </div>
                              <div class="form-modal__footer">
                                <a onclick="SaveBook('m_f_book', this);" class="btn form-modal__footer-btn">
                                  <i class="bi bi-save"></i>Сохранить
                                </a>
                                <button type="submit" class="btn form-modal__footer-btn">
                                  <i class="bi bi-box-arrow-in-left"></i>Сохранить и закрыть
                                </button>

                              </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                          </div>
                          <div class="tab-pane fade" id="note<?=$model->id;?>">
                            <div class="container form-modal__container">
                                <div class="row form-modal__row">
                                      <?=app\widgets\NotesWidget::widget(
                                          [
                                              "type"=>1,
                                          ]
                                      );?>
                                  </div>
                            </div>
                          </div>
                        
                        </div>


                  </div>
                  
    </div>
            
</div>

  
                    

                      
                   