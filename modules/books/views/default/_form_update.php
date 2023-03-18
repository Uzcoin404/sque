<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;
use kartik\select2\Select2
?>
<div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Редактирование книги: <?=$model->name;?></h5>
        <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
  <div class="modal-body">
                <?php $form = ActiveForm::begin(
                    [
                        'id'=>'m_f_book',
                        'options' => [
                          'class' => 'form-modal'
                        ],
                        'action' => '/books/update/'.$model->id,
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
                      <div class="col-12 col-md-4">

                        <?= $form->field($model, 'date_create')->textInput(['class'=>'','maxlength' => true,'type' => 'date','value'=>date('Y-m-d',$model->date_create)])->label() ?>
                      </div>
                      <div class="col-12 col-md-4">

                          <?= $form->field($model, 'date_end')->textInput(['class'=>'','maxlength' => true,'type' => 'date','value'=>date('Y-m-d',$model->date_end)])->label() ?>
                      </div>
                      <div class="col-12 col-md-4">

                          <?= $form->field($model, 'plan_words')->textInput(['class'=>'','max' => 9999999999,'type' => 'number'])->label() ?>
                      </div>
                      <div class="col-12 col-md-6">
                      <?PHP IF($model->image):?>
                              <div style="background:URL('/img/books/<?=$model->image;?>');" class="preview-image img-responsive"> </div>
                          <?PHP ELSE:?>
                              <div src="" class="preview-image img-responsive"></div>
                          <?PHP ENDIF;?>
                         
                      </div>
                      <div class="col-12 col-md-6">
                        <?= $form->field($model, 'imageFile')->fileInput(['class'=>'','placeholder' => 'Изображение',
                          'onchange'=>'readURL(this);',
                          "accept"=>".png, .jpg",
                          ]) ?>
                        <a onclick="ClearBookImage(this);"  data-id="<?=$model->id;?>" class="btn form-modal__btn">
                        <i class="bi bi-trash"></i>Очистить изображение
                          </a>
                      </div>
                      <div class="col-12">
                      <?= $form->field($model, 'group',['inputOptions' => ['class'=>'','id' => 'update-model-id_group-'.$model->id]])->widget(Select2::classname(), [
                            'data' => $model->getGroupsList(),
                            'language' => 'ru',
                            'options' => [ 'multiple' => true, 'prompt' => '...','value'=>$model->id_group],
                            'pluginOptions' => [
                                //'tags' => true,
                            ],
                            
                        ])->label();?>
                       </div>
                      <?PHP IF(!$model->main):?>
                      <div class="col-12">
                        <?= $form->field($model, 'main')->checkbox(['class'=>'checkbox-main'],false)->label();?>
                         
                      </div>
                      <?PHP ELSE:?>
                      <div class="col-12">
                        <?= $form->field($model, 'main')->checkbox(['class'=>'checkbox-main','disabled'=>'disabled'],false)->label();?>
                         
                      </div>
                      <?PHP ENDIF;?>
             


            </div>
              <div class="form-modal__footer">
                
                <a onclick="SaveBook('m_f_book',this);" class="btn form-modal__footer-btn">
                  <i class="bi bi-save"></i>Сохранить
                </a>
                <button type="submit" class="btn form-modal__footer-btn">
                  <i class="bi bi-box-arrow-in-left"></i>Сохранить и закрыть
                </button>
                <a onclick="DeleteBook(this,1);"  data-id="<?=$model->id;?>" class="btn form-modal__footer-btn">
                  <i class="bi bi-trash"></i>Удалить
                </a>
              </div>
            </div>
                <?php ActiveForm::end(); ?>
