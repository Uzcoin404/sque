<?PHP
use app\modules\User;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;
use yii\helpers\Html;
use yii\jui\DatePicker;
use kartik\select2\Select2;
?>
<div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel"><?=\Yii::t('app','Images user')?>: <?=$model->username;?></h5>
      </div>
      <div class="modal-body">
          <?php $form = ActiveForm::begin(
                    [
                        'id' => 'update_user',
                        'options' => [
                            'class' => 'form-modal'
                        ],
                        'action' => '/profile/ajx/update',
                        'enableAjaxValidation' => false,
                    ]
            ); ?>
             <div class="container form-modal__container">
                        <div class="row form-modal__row">
                            <div class="col-12 col-md-6">
                               
                                            <div src="" class="preview-image img-responsive"></div>
                                       
                            </div>
                            <div class="col-12 col-md-6">
                                <?= $form->field($model, 'imageFile')->fileInput(['placeholder' => 'Изображение',
                                'onchange'=>'readURL(this);',
                                "accept"=>".png, .jpg",
                                ]) ?>
                                                    <div class="form-modal__footer">
                      <button type="submit" class="btn form-modal__footer-btn">
                        <i class="bi bi-box-arrow-in-left"></i>Сохранить
                      </button>
                    </div>
                            </div>

                  </div>
              </div>
            <?php $form->end(); ?>
      </div>
</div>