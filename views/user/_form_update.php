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
        <h5 class="modal-title" id="modalLabel">Редактирование данных пользователя: <?=$model->email;?></h5>
        <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
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
                            <div class="col-12">
                              <?= $form->field($model, 'name')->textInput(['class'=>'','maxlength' => 60,'placeholder' => 'Ваше имя']) ?>
                            </div>
                            <div class="col-12">
                              <?= $form->field($model, 'second_name')->textInput(['class'=>'','maxlength' => 60,'placeholder' => 'Ваша фамилия']) ?>
                            </div>
                            <div class="col-12 col-md-6">
              
                                <?PHP IF($model->image):?>
                                            <div style="background:URL('/img/users/<?=$model->image;?>');" class="preview-image img-responsive"></div> 
                                        <?PHP ELSE:?>
                                            <div src="" class="preview-image img-responsive"></div>
                                        <?PHP ENDIF;?>
                                
                            </div>
                            <div class="col-12 col-md-6">
                                <?= $form->field($model, 'imageFile')->fileInput(['placeholder' => 'Изображение',
                                'onchange'=>'readURL(this);',
                                "accept"=>".png, .jpg",
                                ]) ?>
                                        <a onclick="ClearUserImage(this);" data-token="<?=$model->accessToken;?>" class="btn form-modal__btn">
                                                <i class="bi bi-trash"></i> Очистить изображение
                                        </a>
                            </div>
                    <div class="form-modal__footer">
                      <button type="submit" class="btn form-modal__footer-btn">
                        <i class="bi bi-box-arrow-in-left"></i>Сохранить
                      </button>
                    </div>
                  </div>
              </div>
            <?php $form->end(); ?>
      </div>
</div>