<?PHP
use app\modules\items\models\BookItems;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;
use yii\helpers\Html;
use yii\jui\DatePicker;
use kartik\select2\Select2;
use app\modules\books\models\Books;
 $user = Yii::$app->user->identity;
$active_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
?>
<div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Создание предмета</h5>
        <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
  <div class="modal-body">
    <div class="tab">
            <ul class="nav nav-tabs">
                <li class="nav-item ">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#main_<?=$model->id;?>">Основная информация</button>
                </li>
                <li class="nav-item"  data-bs-toggle="popover" tabindex="0"  data-bs-trigger="focus"  role="button" data-bs-placement="bottom" data-bs-content="Заметки доступны только для сохраненных объектов">
                    <button class="nav-link">Заметки</button>
                </li>
            </ul>
      <div class="tab-content">
        <div class="tab-pane fade active show" id="main_<?=$model->id;?>">
            <?php $form = ActiveForm::begin(
              [
                'id' => 'create_item',
                'options' => [
                  'class' => 'form-modal'
                ],
                'action' => '/items/create',
                'enableAjaxValidation' => false,
                'validationUrl' => '/items/validate',
              ]
            ); ?>
                <div class="container form-modal__container">
                  <div class="row form-modal__row">
                  <div class="col-12">
                      <?= $form->field($model, 'name',['inputOptions' => ['id' => 'create-items-name-'.$model->id]])->textArea(['class'=>'','maxlength' => true])->label() ?>
                    </div>        
                    <div class="col-12">     
                      <?= $form->field($model, 'description',['inputOptions' => ['id' => 'update-items-description-'.$model->id]])->textArea(['class'=>'','maxlength' => true])->label() ?>
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
                    <div class="col-12 col-md-6">
                                  <?PHP IF($model->image):?>
                                    <div style="background:URL('/img/items/<?=$model->image;?>');" class="preview-image img-responsive"> </div>
                                  <?PHP ELSE:?>
                                      <div src="" class="preview-image img-responsive"></div>
                                  <?PHP ENDIF;?>
                              </div>
                              <div class="col-12 col-md-6">
                                <?= $form->field($model, 'imageFile')->fileInput(['placeholder' => 'Изображение',
                                  'onchange'=>'readURL(this);',
                                  "accept"=>".png, .jpg",
                                  ]) ?>
                                  <a onclick="ClearBookItemsImage(this);"  data-id="0" class="btn form-modal__btn">
                                  <i class="bi bi-trash"></i>Очистить изображение
                                  </a>
                              </div>
                  </div>
        
                                <div class="form-modal__footer">
                                <a  OnClick="SaveItem('create_item',this);" class="btn form-modal__footer-btn">
                                  <i class="bi bi-save"></i>Сохранить
                                </a>
                                <button type="submit" class="btn form-modal__footer-btn">
                                  <i class="bi bi-box-arrow-in-left"></i>Сохранить и закрыть
                                </button>
                                <a OnClick="SaveItemAndAdd('create_item',this);" class="btn form-modal__footer-btn">
                                  <i class="bi bi-arrow-repeat"></i>Сохранить и добавить
                                </a>
                              </div>
      </div>
      </div>

</div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>
         
             
