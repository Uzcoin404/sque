<?php
$this->title = 'Профиль пользователя';
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;
use kartik\select2\Select2
?>
<div class="container-fluid page__container">

<header class="header">
    <div class="page__top-bar">
        <h1 class="page__title"><?=$this->title;?></h1>

        <div class="theme-style-toggler">
            <div class="ballun"></div>
            <span class="light">День</span>
            <span class="dark">Ночь</span>
        </div>
        <div id="rate" class="rate" data-bs-toggle="tooltip" data-bs-html="true" title=""><i class="bi bi-bell"></i><span class="position-absolute top-0 start-100 translate-middle p-2 border border-light rounded-circle"></span> </div>
    </div>
</header>
<div class="row page__row">
<aside class="sidebar">
        <div class="mobile-sidebar__toggler">
          <i class="bi bi-chevron-double-left" title="Скрыть боковую панель"></i>
        </div>

        <div class="groups filter_note_objects">
            <div class="groups__title">Дополнительное меню</div>
              <div style="max-height: 150px;padding-right: 8px;" data-simplebar data-simplebar-auto-hide="false">
                <div class="groups__items-container">

                  <div class="groups-item">
                      <a href="">
                          <div class="c_pointer list_filter book" data-id="1">
                              Общие
                          </div>
                      </a>
                  </div>

                </div>
              </div>
            </div>  
          
      </aside>
  <div class="col page__col">
    <div class="main">
    <div class="sidebar__toggler">
            <i class="bi bi-chevron-double-left" title="Скрыть боковую панель"></i>
          </div>
      <div id="books_list" class="books_list">
        <div class="row row-cols-1 row-cols-md-1">
                  <div class="col" >
                  <?php $form = ActiveForm::begin(); ?>
                
                <div class="form-group field-user-email">
                    <label class="control-label" for="user-email">Имя пользователя</label>
                    <p><?= $model->username; ?></p>
                </div>
                <?= $form->field($model, 'email')->textInput(['maxlength' => true,'placeholder' => 'Email']) ?>

                <?PHP IF($model->image):?>
                                            <div style="background:URL('/img/users/<?=$model->image;?>');" class="preview-image img-responsive"></div> 
                                        <?PHP ELSE:?>
                                            <div src="" class="preview-image img-responsive"></div>
                                        <?PHP ENDIF;?>
                <?= $form->field($model, 'imageFile')->fileInput(['placeholder' => 'Изображение',
                'onchange'=>'readURL(this);',
                "accept"=>".png, .jpg",
                ]) ?>
                
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
                  </div>
                  
  
                  

        </div>

      </div>
<!-- mobile fixed-footer -->
<div class="mobile-footer">
            <div class="groups-mobile-control">
                <a data="mobile-toggle"><i class="bi bi-list"></i></a>
                <a onclick="GetActiveStory();"><i class="bi bi-info-circle"></i></a>
                <a onclick="AddThroughNote(this);" ><i class="bi bi-plus-lg"></i></a>
                 <a class="mobile-sidebar__toggler"><i class="bi bi-funnel"></i></a>
                
            </div>
</div>
</div>
</div>

</div>
   