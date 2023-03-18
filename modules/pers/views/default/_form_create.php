<?PHP
use app\modules\pers\models\BookPers;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;
use yii\helpers\Html;
use yii\jui\DatePicker;
use kartik\select2\Select2

?>
<div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Создание персонажа</h5>
        <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <div class="tab">
          <ul class="nav nav-tabs">
              <li class="nav-item ">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#add-main">Основная информация</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#add-knowledge">Знакомство</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#add-options">Характеристики</button>
              </li>
              <li class="nav-item"  data-bs-toggle="popover" tabindex="0"  data-bs-trigger="focus"  role="button" data-bs-placement="bottom" data-bs-content="Заметки доступны только для сохраненных объектов">
                      <button class="nav-link">Заметки</button>
              </li>
          </ul>
          <div class="tab-content">
              <?php $form = ActiveForm::begin(
                [
                  'id' => 'create_pers',
                  'options' => [
                    'class' => 'form-modal'
                  ],
                  'action' => '/pers/create',
                  'enableAjaxValidation' => false,
                  'validationUrl' => '/pers/validate',
                ]
              ); ?>
                  <div class="tab-pane fade active show" id="add-main">
                    <div class="container form-modal__container">
                      <div class="row form-modal__row">
                      <div class="" hidden>
                    <?= $form->field($model, 'id_book')->dropDownList($model->getBooks())->label();?>
                  </div>
                  <div class="col-12">
                    <?= $form->field($model, 'name',['inputOptions' => ['id' => 'update-model-name-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                  </div>
                  <div class="col-12">
                    <?= $form->field($model, 'surname',['inputOptions' => ['id' => 'update-model-surname-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                  </div>
                  <div class="col-12">
                    <?= $form->field($model, 'nickname',['inputOptions' => ['id' => 'update-model-nickname-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                  </div>
                  <div class="col-12">
                    <?= $form->field($model, 'aliasname',['inputOptions' => ['id' => 'update-model-aliasname-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
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
                  <div class="col-12 col-md-4">
                    <?= $form->field($model, 'bod',['inputOptions' => ['id' => 'update-model-bod-']])->textInput(['class'=>'','maxlength' => true,'value'=>""])->label() ?>
                    
                  </div>
                  <div class="col-12 col-md-4">
                    <?= $form->field($model, 'dod',['inputOptions' => ['id' => 'update-model-dod-']])->textInput(['class'=>'','maxlength' => true,'value'=>""])->label() ?>
                    
                  </div>
                  <div class="col-12 col-md-4">
                    <?= $form->field($model, 'old',['inputOptions' => ['id' => 'update-model-old-']])->textInput(['class'=>'','maxlength' => true,'type' => 'number'])->label() ?>
                    
                  </div>
                  <div class="col-12">
                    <?= $form->field($model, 'profession',['inputOptions' => ['id' => 'update-model-profession-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                  </div>
                  <div class="col-12">
                    <?= $form->field($model, 'nationality',['inputOptions' => ['id' => 'update-model-nationality-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                  </div>
                  <div class="col-12">
                    <?= $form->field($model, 'race',['inputOptions' => ['id' => 'update-model-race-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                  </div>
                  <div class="col-12">
                    <?= $form->field($model, 'gender',['inputOptions' => ['id' => 'update-model-gender-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                  </div>
                  <div id="parents_add" class="col-12">
                    <div class="row">
                        <div class="col-12">
                        <label class="control-label" >Связи персонажа</label>
                        </div>
                    </div>
                    Выбор связей доступен только для созданных персонажей. Пожалуйста, сохраните объект.
                  </div>
                  <div class="col-12">
                    <?= $form->field($model, 'archetype',['inputOptions' => ['class'=>'','id' => 'update-model-archetype-']])->widget(Select2::classname(), [
                          'data' => $model->getArchytype(),
                          'language' => 'ru',
                          'options' => [ 'multiple' => false],
                          'pluginOptions' => [
                              //'tags' => true,
                          ],
                      ])->label();?>
                  </div>
                  <div class="col-12">
                    <?= $form->field($model, 'ritp',['inputOptions' => ['class'=>'','id' => 'update-model-ritp-']])->widget(Select2::classname(), [
                          'data' => $model->getRitp(),
                          'language' => 'ru',
                          'options' => [ 'multiple' => false],
                          'pluginOptions' => [
                              //'tags' => true,
                          ],
                      ])->label();?>
                  </div>
                  <div class="col-12 col-md-6">
            
                            <?PHP IF($model->image):?>
                                            <div style="background:URL('/img/pers/<?=$model->image;?>');" class="preview-image img-responsive"> </div>
                                        <?PHP ELSE:?>
                                            <div src="" class="preview-image img-responsive"></div>
                                        <?PHP ENDIF;?>
                          
                        </div>
                        <div class="col-12 col-md-6">
                          <?= $form->field($model, 'imageFile')->fileInput(['placeholder' => 'Изображение',
                            'onchange'=>'readURL(this);',
                            "accept"=>".png, .jpg",
                            ]) ?>
                            <a onclick="ClearBookPersImage(this);"  data-id="0" class="btn form-modal__btn">
                                <i class="bi bi-trash"></i>Очистить изображение
                            </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="add-knowledge">
                    <div class="container form-modal__container">
                      <div class="row form-modal__row">
                      <div class="col-12">
                        <?= $form->field($model, 'hystori',['inputOptions' => ['id' => 'update-model-hystori']])->textarea(['class'=>'','rows' => 3])->label() ?>
                      </div>
                      <div class="col-12">
                        <?= $form->field($model, 'in_motivation',['inputOptions' => ['id' => 'update-model-in_motivation']])->textarea(['class'=>'','rows' => 3])->label() ?>     
                      </div>
                      <div class="col-12">
                        <?= $form->field($model, 'out_motivation',['inputOptions' => ['id' => 'update-model-out_motivation']])->textarea(['class'=>'','rows' => 3])->label() ?>     
                      </div>
                      <div class="col-12">
                        <?= $form->field($model, 'obstacles',['inputOptions' => ['id' => 'update-model-obstacles']])->textarea(['class'=>'','rows' => 3])->label() ?>
                      </div>
                      <div class="col-12">
                        <?= $form->field($model, 'arka',['inputOptions' => ['id' => 'update-model-arka']])->textarea(['class'=>'','rows' => 3])->label() ?>
                      </div>
                      <div class="col-12">
                        <?= $form->field($model, 'role_in_history',['inputOptions' => ['id' => 'update-model-role_in_history']])->textarea(['class'=>'','rows' => 3])->label() ?>
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade " id="add-options">
                    <div class="container form-modal__container">
                      <div class="row form-modal__row">
                        <ul class="nav nav-tabs nav-tabs--sm">
                                  <li class="nav-item ">
                                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#add-look">Внешность</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link" data-bs-toggle="tab" data-bs-target="#add-person">Личность</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link" data-bs-toggle="tab" data-bs-target="#add-live_path">Жизненный путь</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link" data-bs-toggle="tab" data-bs-target="#add-ffr">Семья, друзья, отношения</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link" data-bs-toggle="tab" data-bs-target="#add-work">Работа, образование, хобби</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link" data-bs-toggle="tab" data-bs-target="#add-interes">Интересы</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link" data-bs-toggle="tab" data-bs-target="#add-own">Собственность</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link" data-bs-toggle="tab" data-bs-target="#add-spirit">Духовность и ценности</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link" data-bs-toggle="tab" data-bs-target="#add-live">Повседневная жизнь</a>
                                  </li>
                              </ul>
                        <div class="tab-content">
                                      <div class="tab-pane fade active show" id="add-look">
                                        <div class="container form-modal__container">
                                          <div class="row form-modal__row">
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_height',['inputOptions' => ['id' => 'update-model-look_height-']])->textarea(['class'=>'','maxlength' => true,'type' => 'number'])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_weight',['inputOptions' => ['id' => 'update-model-look_weight-']])->textarea(['class'=>'','maxlength' => true,'type' => 'number'])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_body_type',['inputOptions' => ['id' => 'update-model-look_body_type-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_hair_color',['inputOptions' => ['id' => 'update-model-look_hair_color-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_hair_style',['inputOptions' => ['id' => 'update-model-look_hair_style-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_eye_color',['inputOptions' => ['id' => 'update-model-look_eye_color-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_eye_style',['inputOptions' => ['id' => 'update-model-look_eye_style-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_glasses',['inputOptions' => ['id' => 'update-model-look_glasses']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                          <div class="col-12">
                                          <?= $form->field($model, 'look_features',['inputOptions' => ['id' => 'update-model-look_features']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_skin',['inputOptions' => ['id' => 'update-model-look_skin']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_makeup',['inputOptions' => ['id' => 'update-model-look_makeup-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_scars',['inputOptions' => ['id' => 'update-model-look_scars']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_birthmarks',['inputOptions' => ['id' => 'update-model-look_birthmarks']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_tatoo',['inputOptions' => ['id' => 'update-model-look_tatoo']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_disabilities',['inputOptions' => ['id' => 'update-model-look_disabilities']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_style',['inputOptions' => ['id' => 'update-model-look_style']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_footwear',['inputOptions' => ['id' => 'update-model-look_footwear']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_to_clothes',['inputOptions' => ['id' => 'update-model-look_to_clothes']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'look_comment',['inputOptions' => ['id' => 'update-model-look_comment']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                        </div>
                                        </div>
                                      </div>
                                      <div class="tab-pane fade" id="add-person">
                                        <div class="container form-modal__container">
                                          <div class="row form-modal__row">
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q1',['inputOptions' => ['id' => 'update-model-person_q1-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q2',['inputOptions' => ['id' => 'update-model-person_q2-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q3',['inputOptions' => ['id' => 'update-model-person_q3-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q4',['inputOptions' => ['id' => 'update-model-person_q4-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q5',['inputOptions' => ['id' => 'update-model-person_q5-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q6',['inputOptions' => ['id' => 'update-model-person_q6-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q7',['inputOptions' => ['id' => 'update-model-person_q7-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q8',['inputOptions' => ['id' => 'update-model-person_q8-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q9',['inputOptions' => ['id' => 'update-model-person_q9-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q10',['inputOptions' => ['id' => 'update-model-person_q10-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q11',['inputOptions' => ['id' => 'update-model-person_q11-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q12',['inputOptions' => ['id' => 'update-model-person_q12-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q13',['inputOptions' => ['id' => 'update-model-person_q13-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q14',['inputOptions' => ['id' => 'update-model-person_q14-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q15',['inputOptions' => ['id' => 'update-model-person_q15-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q16',['inputOptions' => ['id' => 'update-model-person_q16-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q17',['inputOptions' => ['id' => 'update-model-person_q17-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q18',['inputOptions' => ['id' => 'update-model-person_q18-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q19',['inputOptions' => ['id' => 'update-model-person_q19-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q20',['inputOptions' => ['id' => 'update-model-person_q20-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q21',['inputOptions' => ['id' => 'update-model-person_q21-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q22',['inputOptions' => ['id' => 'update-model-person_q22-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q23',['inputOptions' => ['id' => 'update-model-person_q23-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q24',['inputOptions' => ['id' => 'update-model-person_q24-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q25',['inputOptions' => ['id' => 'update-model-person_q25-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q26',['inputOptions' => ['id' => 'update-model-person_q26-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q27',['inputOptions' => ['id' => 'update-model-person_q27-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q28',['inputOptions' => ['id' => 'update-model-person_q28-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_q29',['inputOptions' => ['id' => 'update-model-person_q29-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'person_comment',['inputOptions' => ['id' => 'update-model-person_comment']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                        </div>
                                        </div>
                                      </div>
                                      <div class="tab-pane fade" id="add-live_path">
                                        <div class="container form-modal__container">
                                          <div class="row form-modal__row">
                                          <div class="col-12">
                                            <?= $form->field($model, 'lifepath_q1',['inputOptions' => ['id' => 'update-model-lifepath_q1-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'lifepath_q2',['inputOptions' => ['id' => 'update-model-lifepath_q2-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'lifepath_q3',['inputOptions' => ['id' => 'update-model-lifepath_q3-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'lifepath_q4',['inputOptions' => ['id' => 'update-model-lifepath_q4-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'lifepath_q5',['inputOptions' => ['id' => 'update-model-lifepath_q5-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'lifepath_q6',['inputOptions' => ['id' => 'update-model-lifepath_q6-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'lifepath_q7',['inputOptions' => ['id' => 'update-model-lifepath_q7-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'lifepath_q8',['inputOptions' => ['id' => 'update-model-lifepath_q8-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'lifepath_q9',['inputOptions' => ['id' => 'update-model-lifepath_q9-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'lifepath_10',['inputOptions' => ['id' => 'update-model-lifepath_10-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'lifepath_comment',['inputOptions' => ['id' => 'update-model-lifepath_comment']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                        </div>
                                        </div>
                                      </div>
                                      <div class="tab-pane fade" id="add-ffr">
                                        <div class="container form-modal__container">
                                          <div class="row form-modal__row">
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q1',['inputOptions' => ['id' => 'update-model-ffr_q1-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q2',['inputOptions' => ['id' => 'update-model-ffr_q2-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q3',['inputOptions' => ['id' => 'update-model-ffr_q3-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q4',['inputOptions' => ['id' => 'update-model-ffr_q4-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q5',['inputOptions' => ['id' => 'update-model-ffr_q5-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q6',['inputOptions' => ['id' => 'update-model-ffr_q6-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q7',['inputOptions' => ['id' => 'update-model-ffr_q7-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q8',['inputOptions' => ['id' => 'update-model-ffr_q8-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q9',['inputOptions' => ['id' => 'update-model-ffr_q9-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q10',['inputOptions' => ['id' => 'update-model-ffr_q10-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q11',['inputOptions' => ['id' => 'update-model-ffr_q11-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q12',['inputOptions' => ['id' => 'update-model-ffr_q12-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q13',['inputOptions' => ['id' => 'update-model-ffr_q13-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q14',['inputOptions' => ['id' => 'update-model-ffr_q14-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q15',['inputOptions' => ['id' => 'update-model-ffr_q15-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q16',['inputOptions' => ['id' => 'update-model-ffr_q16-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q17',['inputOptions' => ['id' => 'update-model-ffr_q17-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q18',['inputOptions' => ['id' => 'update-model-ffr_q18-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_q19',['inputOptions' => ['id' => 'update-model-ffr_q19-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'ffr_comment',['inputOptions' => ['id' => 'update-model-ffr_comment']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                        </div>
                                        </div>
                                      </div>
                                      <div class="tab-pane fade" id="add-work">
                                        <div class="container form-modal__container">
                                          <div class="row form-modal__row">
                                          <div class="col-12">
                                            <?= $form->field($model, 'work_q1',['inputOptions' => ['id' => 'update-model-work_q1-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'work_q2',['inputOptions' => ['id' => 'update-model-work_q2-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'work_q3',['inputOptions' => ['id' => 'update-model-work_q3-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'work_q4',['inputOptions' => ['id' => 'update-model-work_q4-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'work_q5',['inputOptions' => ['id' => 'update-model-work_q5-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'work_q6',['inputOptions' => ['id' => 'update-model-work_q6-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'work_q7',['inputOptions' => ['id' => 'update-model-work_q7-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'work_q8',['inputOptions' => ['id' => 'update-model-work_q8-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'work_q9',['inputOptions' => ['id' => 'update-model-work_q9-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'work_q10',['inputOptions' => ['id' => 'update-model-work_q10-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'work_comment',['inputOptions' => ['id' => 'update-model-work_comment']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                        </div>
                                        </div>
                                      </div>
                                      <div class="tab-pane fade" id="add-interes">
                                        <div class="container form-modal__container">
                                          <div class="row form-modal__row">
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q1',['inputOptions' => ['id' => 'update-model-interest_q1-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q2',['inputOptions' => ['id' => 'update-model-interest_q2-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q3',['inputOptions' => ['id' => 'update-model-interest_q3-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q4',['inputOptions' => ['id' => 'update-model-interest_q4-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q5',['inputOptions' => ['id' => 'update-model-interest_q5-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q6',['inputOptions' => ['id' => 'update-model-interest_q6-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q7',['inputOptions' => ['id' => 'update-model-interest_q7-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q8',['inputOptions' => ['id' => 'update-model-interest_q8-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q9',['inputOptions' => ['id' => 'update-model-interest_q9-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q10',['inputOptions' => ['id' => 'update-model-interest_q10-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q11',['inputOptions' => ['id' => 'update-model-interest_q11-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q12',['inputOptions' => ['id' => 'update-model-interest_q12-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q13',['inputOptions' => ['id' => 'update-model-interest_q13-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q14',['inputOptions' => ['id' => 'update-model-interest_q14-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q15',['inputOptions' => ['id' => 'update-model-interest_q15-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q16',['inputOptions' => ['id' => 'update-model-interest_q16-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q17',['inputOptions' => ['id' => 'update-model-interest_q17-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q18',['inputOptions' => ['id' => 'update-model-interest_q18-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q19',['inputOptions' => ['id' => 'update-model-interest_q19-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_q20',['inputOptions' => ['id' => 'update-model-interest_q20-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'interest_comment',['inputOptions' => ['id' => 'update-model-interest_comment']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                        </div>
                                        </div>
                                      </div>
                                      <div class="tab-pane fade" id="add-own">
                                        <div class="container form-modal__container">
                                          <div class="row form-modal__row">
                                          <div class="col-12">
                                            <?= $form->field($model, 'own_q1',['inputOptions' => ['id' => 'update-model-own_q1-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'own_q2',['inputOptions' => ['id' => 'update-model-own_q2-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'own_q3',['inputOptions' => ['id' => 'update-model-own_q3-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'own_q4',['inputOptions' => ['id' => 'update-model-own_q4-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'own_q5',['inputOptions' => ['id' => 'update-model-own_q5-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'own_q6',['inputOptions' => ['id' => 'update-model-own_q6-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'own_q7',['inputOptions' => ['id' => 'update-model-own_q7-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'own_comment',['inputOptions' => ['id' => 'update-model-own_comment']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                        </div>
                                        </div>
                                      </div>
                                      <div class="tab-pane fade" id="add-spirit">
                                      <div class="container form-modal__container">
                                          <div class="row form-modal__row">
                                          <div class="col-12">
                                            <?= $form->field($model, 'spirit_q1',['inputOptions' => ['id' => 'update-model-spirit_q1-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'spirit_q2',['inputOptions' => ['id' => 'update-model-spirit_q2-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'spirit_q3',['inputOptions' => ['id' => 'update-model-spirit_q3-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'spirit_q4',['inputOptions' => ['id' => 'update-model-spirit_q4-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'spirit_q5',['inputOptions' => ['id' => 'update-model-spirit_q5-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'spirit_q6',['inputOptions' => ['id' => 'update-model-spirit_q6-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'spirit_q7',['inputOptions' => ['id' => 'update-model-spirit_q7-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'spirit_q8',['inputOptions' => ['id' => 'update-model-spirit_q8-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'spirit_q9',['inputOptions' => ['id' => 'update-model-spirit_q9-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'spirit_q10',['inputOptions' => ['id' => 'update-model-spirit_q10-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'spirit_comment',['inputOptions' => ['id' => 'update-model-spirit_comment']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                        </div>
                                        </div>
                                      </div>
                                      <div class="tab-pane fade" id="add-live">
                                        <div class="container form-modal__container">
                                          <div class="row form-modal__row">
                                          <div class="col-12">
                                            <?= $form->field($model, 'live_q1',['inputOptions' => ['id' => 'update-model-live_q1-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'live_q2',['inputOptions' => ['id' => 'update-model-live_q2-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'live_q3',['inputOptions' => ['id' => 'update-model-live_q3-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'live_q4',['inputOptions' => ['id' => 'update-model-live_q4-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'live_q5',['inputOptions' => ['id' => 'update-model-live_q5-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'live_q6',['inputOptions' => ['id' => 'update-model-live_q6-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'live_q7',['inputOptions' => ['id' => 'update-model-live_q7-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'live_q8',['inputOptions' => ['id' => 'update-model-live_q8-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'live_q9',['inputOptions' => ['id' => 'update-model-live_q9-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'live_q10',['inputOptions' => ['id' => 'update-model-live_q10-']])->textarea(['class'=>'','maxlength' => true])->label() ?>
                                          </div>
                                          <div class="col-12">
                                            <?= $form->field($model, 'live_comment',['inputOptions' => ['id' => 'update-model-live_comment']])->textarea(['class'=>'','rows' => 3])->label() ?>
                                          </div>
                                        </div>
                                        </div>
                                      </div>
                          
                              </div>
                      </div>
                    </div>
                  </div>

                  <div class="container form-modal__container">
                    <div class="form-modal__footer">
                        <a OnClick="SavePers('create_pers',this);" class="btn form-modal__footer-btn">
                            <i class="bi bi-save"></i>Сохранить
                        </a>
                        <button type="submit" class="btn form-modal__footer-btn">
                            <i class="bi bi-box-arrow-in-left"></i>Сохранить и закрыть
                        </button>
                        <a OnClick="SavePersAndAdd('create_pers',this);" class="btn form-modal__footer-btn">
                            <i class="bi bi-arrow-repeat"></i>Сохранить и добавить
                        </a>

                    </div>
                  </div>
              <?php $form->end(); ?>
          </div>
        </div>
      </div>
</div>
    