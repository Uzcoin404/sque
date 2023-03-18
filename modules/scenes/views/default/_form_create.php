<?PHP
use app\modules\scenes\models\BookScenes;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;
use yii\helpers\Html;
use yii\jui\DatePicker;
use kartik\select2\Select2
?>
<div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Создание сцены</h5>
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
                    <?php 
  
                    $form = ActiveForm::begin(
                    [
                        'id' => 'create_book_scene',
                        'options' => [
                            'class' => 'form-modal'
                        ],
                        'action' => '/scenes/create',
                        'enableAjaxValidation' => false,
                        'validationUrl' => '/scenes/validate',
                    ]
                    ); ?>
                    <div class="tab-pane fade active show" id="add-main">
                        <div class="container form-modal__container">
                            <div class="row form-modal__row">
                                <div class="col-12">
                                    <?= $form->field($model, 'name',['inputOptions' => ['id' => 'create-scene-name']])->textArea(['class'=>'','maxlength' => true,'placeholder' => 'Название сцены'])->label() ?>
                                </div>
                                <div class="col-12">
                                    <?= $form->field($model, 'plan',['inputOptions' => ['id' => 'update-model-own_comment-'.$model->id]])->textarea(['class'=>'','rows' => 3])->label() ?>
                                </div>
                                <div class="col-12">
                                    <?= $form->field($model, 'scene_data',['inputOptions' => ['id' => 'update-model-scene_date-'.$model->id]])->textInput(['class'=>'','rows' => 3])->label() ?>
                                </div>
                                <div class="col-12">
                                    <?= $form->field($model, 'scene_weather',['inputOptions' => ['id' => 'update-model-scene_date-'.$model->id]])->textArea(['class'=>'','rows' => 3])->label() ?>
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
                                            <div style="background:URL('/img/scenes/<?=$model->image;?>');" class="preview-image img-responsive"> </div>
                                        <?PHP ELSE:?>
                                            <div src="" class="preview-image img-responsive"></div>
                                        <?PHP ENDIF;?>
                                
                            </div>
                            <div class="col-12 col-md-6">
                                <?= $form->field($model, 'imageFile')->fileInput(['placeholder' => 'Изображение',
                                'onchange'=>'readURL(this);',
                                "accept"=>".png, .jpg",
                                ]) ?>
                                <a onclick="ClearBookScenesImage(this);"  data-id="0" class="btn form-modal__btn">
                                <i class="bi bi-trash"></i>Очистить изображение
                                </a>
                            
                            </div>

                            <div class="form-modal__footer">
                                    <a OnClick="CreateScenesOnHide('create_book_scene',this);" class="btn form-modal__footer-btn">
                                    <i class="bi bi-save"></i>Сохранить и писать
                                    </a>
                                    <button type="submit" class="btn form-modal__footer-btn">
                                    <i class="bi bi-box-arrow-in-left"></i>Сохранить и закрыть
                                    </button>
                                    <a OnClick="CreateScenesAndAdd('create_book_scene',this);" class="btn form-modal__footer-btn">
                                    <i class="bi bi-arrow-repeat"></i>Сохранить и добавить еще сцену
                                    </a>
                            </div>
                        </div>
                        
                    </div>
                    <?php $form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

         