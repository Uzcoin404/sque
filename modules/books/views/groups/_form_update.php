<?PHP
use app\modules\items\models\BookItems;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;
use yii\helpers\Html;
use yii\jui\DatePicker;
use kartik\select2\Select2;
?>
<div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Редактирование группы книг: <?=$model->name;?></h5>
        <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
  <div class="modal-body">

         <?php $form = ActiveForm::begin(
           [
            'id' => 'm_f_book_s_p',
            'options' => [
              'class' => 'form-modal'
            ],
            'action' => '/books/groups/update/'.$model->id,
           ]
         ); ?>
     <div class="container form-modal__container">
          <div class="row form-modal__row">
            <div class="col-12">
              <?= $form->field($model, 'name',['inputOptions' => ['id' => 'create-books-groups-name-'.$model->id]])->textInput(['class'=>'','maxlength' => true])->label() ?>
            </div>
            <div class="col-12">
              <?= $form->field($model, 'color',['inputOptions' => ['class'=>'','id' => 'create-books-groups-color-'.$model->id]])->widget(alexantr\colorpicker\ColorPicker::className()) ?>
            </div>
        </div>
        <div class="form-modal__footer">
                                <button type="submit" class="btn form-modal__footer-btn">
                                  <i class="bi bi-box-arrow-in-left"></i>Сохранить и закрыть
                                </button>

                              </div>
        </div>
        </div>
        <?php $form->end(); ?>
        </div>