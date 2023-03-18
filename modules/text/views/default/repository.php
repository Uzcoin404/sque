<?php
        $this->title = $Scenes->name;
    use yii\widgets\ActiveForm;
    use kartik\editors\Summernote;
    use yii\helpers\Html;
    use app\widgets\Notes;
    use kartik\select2\Select2
?>

<?php 
  $this->registerJsFile(
    '@web/js/scenes.js',
    [
        'position' => $this::POS_HEAD    // подключать в <head>
    ]
  );
?>

<?php 
  $this->registerJsFile(
    '@web/js/pers.js',
    [
        'position' => $this::POS_HEAD    // подключать в <head>
    ]
  );
?>

<?php 
  $this->registerJsFile(
    '@web/js/items.js',
    [
        'position' => $this::POS_HEAD    // подключать в <head>
    ]
  );
?>


<?php 
  $this->registerJsFile(
    '@web/js/locations.js',
    [
        'position' => $this::POS_HEAD    // подключать в <head>
    ]
  );
?>


<div class="container-fluid page__container scens__update">

            <header class="header">
                <div class="page__top-bar">
                    <h1 class="page__title">Редактирование сцены</h1>
                    <div class="words-count" id="book_count"></div>
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
          <div class="groups scens_list">
    
          </div>
          <div class="groups pers_list">
    
          </div>
          <div class="groups locations_list">
    
          </div>
          <div class="groups items_list">
    
          </div>
          
      </aside>
      <div class="col page__col">


        <div class="row page__row">
        <div class="editor-top">
                                <div class="editor-top__note-title">

                                      <?php $form = ActiveForm::begin(
                                        [
                                          'id' => 'scenes_title',
                                          'enableAjaxValidation' => true,
                                          'validationUrl' => '/scenes/validate',
                                          'action' => '/scenes/update/text/'.$Scenes->id,

                                        ]
                                      ); ?>
                                    
                                    <i class="bi bi-chat"></i> <?= $form->field($Scenes, 'name',['inputOptions' => ['class'=>'','id' => 'update-scenes-title-name-'.$Scenes->id],'options'=>['tag'=>false]])->textInput(['class'=>'update-scenes-text','rows' => 3])->label(false) ?>
                                    
                            

                                      <?php $form->end(); ?>
                                   
                                </div>
                                <div class="editor-top__date">
                               
                                        
                                            <?php $form = ActiveForm::begin(
                                            [
                                              'id' => 'scenes_date',
                                              'enableAjaxValidation' => true,
                                              'validationUrl' => '/scenes/validate',
                                              'action' => '/scenes/update/text/'.$Scenes->id,

                                            ]
                                          ); ?>
                                        <label class="label-icon-bd-bottom">
                                        <i class="bi bi-clock"></i><?= $form->field($Scenes, 'scene_data',['inputOptions' => ['class'=>'','id' => 'update-scenes-date-name-'.$Scenes->id],'options'=>['tag'=>false]])->textInput(['class'=>'update-scenes-text','rows' => 3])->label(false) ?>
                                        </label>
                                

                                          <?php $form->end(); ?>
                                        
                                   
                                </div>
                                <div class="editor-top__weather">
                                <?php $form = ActiveForm::begin(
                                        [
                                          'id' => 'scenes_weather',
                                          'options' => [
                                            'class' => 'form-editor'
                                        ],
                                          'enableAjaxValidation' => true,
                                          'validationUrl' => '/scenes/validate',
                                          'action' => '/scenes/update/text/'.$Scenes->id,

                                        ]
                                      ); ?>
                                    <label class="label-icon-bd-bottom" for="">
                                    <i class="bi bi-cloud-sun"></i> <?= $form->field($Scenes, 'scene_weather',['inputOptions' => ['class'=>'','id' => 'update-scenes-weather-name-'.$Scenes->id],'options'=>['tag'=>false]])->textInput(['class'=>'update-scenes-text','rows' => 3])->label(false) ?>
                                    </label>
                            

                               
                         
                            <?php $form->end(); ?>
                                </div>
                            </div>


        <div class="col page__col">

        <div class="main">
          <div class="sidebar__toggler">
            <i class="bi bi-chevron-double-left" title="Скрыть боковую панель"></i>
          </div>
                    <div class="editor-container">
                            
                            <div class="editor">
                                    <?php $form = ActiveForm::begin(
                                        [
                                          'id' => 'scenes_text',
                                          'enableAjaxValidation' => true,
                                          'validationUrl' => '/scenes/validate',
                                          'action' => '/text/save/'.$Scenes->id."/".$Scenes->id_book,

                                        ]
                                      ); ?>
                                    
                                        <?php 
                                          echo Summernote::widget([
                                            'language'=>'ru-RU',
                                            'model' => $model,
                                            'attribute' => 'text',
                                            'enableCodeView' => false,
                                            'enableHelp' => false,
                                        ]);?>    

                                      <?php $form->end(); ?>

                            
                              
                            </div>
                            <div class="editor__save-block">
                                <a onclick="SaveScenesAndText();" class="btn  c_pointer">
                                  <i class="bi bi-save"></i>Сохранить
                                </a>
                                <a onclick="SaveScenesAndTextGoMain();" class="btn c_pointer">
                                  <i class="bi bi-reply"></i>Сохранить и закрыть
                                </a>
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
                            <a class="mobile-sidebar__toggler_right"><i class="bi bi-book"></i></a>
                        </div>
        </div>
      </div>
      <!-- SIDEBAR-RIGHT -->
      <div class="right_block">
      <aside class="sidebar sidebar-right">
                    <div class="editor-aside">
                      
                            
                               
                              
                            <?php $form = ActiveForm::begin(
                                        [
                                          'id' => 'scenes_plan',
                                          'options' => [
                                            'class' => 'form-editor'
                                        ],
                                          'enableAjaxValidation' => true,
                                          'validationUrl' => '/scenes/validate',
                                          'action' => '/scenes/update/text/'.$Scenes->id,

                                        ]
                                      ); ?>
                              

                               
                         
                            <fieldset class="fieldset-styled form-editor__fieldset">
                                <label for="">План сцены</label>
                              
                                    
                                    <?= $form->field($Scenes, 'plan',['inputOptions' => ['class'=>'','id' => 'update-scenes-plan-name-'.$Scenes->id],'options'=>['tag'=>false]])->textarea(['class'=>'update-scenes-text','rows' => 3])->label(false) ?>
                                    
                            

                                   
                            </fieldset>
                            <?php $form->end(); ?>
                        
                    </div>
                </aside>
                <label>Заметки</label>
                <div class="notes">
                            
                        </div>
                </div>
  </div>
        </div>
      </div>


</div>





<script>
var THIS_SCENES_ID=<?=$Scenes->id;?>;
jQuery(document).ready(function ($) {
  
 
  initFormAjaxTextThis('scenes_plan');
  initFormAjaxTextThis('scenes_weather');
  initFormAjaxTextThis('scenes_text');
  initFormAjaxTextThis('scenes_date');
  initFormAjaxTextThis('scenes_title');
    intervalId = window.setInterval(function () { $('#scenes_text').submit();  }, 30000);
    getScenesList(<?=$Scenes->id_book;?>);
    getPersList(<?=$Scenes->id;?>);
    CreateBookPersScenes(<?=$Scenes->id;?>,0);
    getItemsList(<?=$Scenes->id;?>);
    getLocationsScenesList(<?=$Scenes->id;?>);
    InitAt(<?=$Scenes->id;?>);
    id_target=<?=$Scenes->id;?>;
            type=2;
            getNotes();
            getScenesNote();
    $('#book_count').text("Написано слов: <?=$model->length;?>");
});

function getActiveSceneList(){
  $('.scens_list .groups__items-container .groups-item').each(function(index,element){
      var id=$(element).attr("data-id");
      if(id==THIS_SCENES_ID){
        $(element).addClass('active');
      }
  });
}


function initFormAjaxText(element){
    $('#'+element).on('beforeSubmit', function () {
        var $yiiform = $(this);
        currentSelect2TagValue($yiiform);
        var formData = new FormData($yiiform[0]);
        // отправляем данные на сервер
   
        $.ajax({
                type: $yiiform.attr('method'),
                url: $yiiform.attr('action'),
                data: formData,
                dataType : 'text',
                processData: false,
                contentType: false,
                cache: false,
            }
        )
        .done(function(data) {
          console.log(data);
          massive=[];
          getPersList(<?=$Scenes->id;?>);
          getItemsList(<?=$Scenes->id;?>);
          getLocationsScenesList(<?=$Scenes->id;?>);
          $('#updateModal').modal('hide');
          
          ShowToastOk();
 
        })
        .fail(function () {
          
        })
    return false; // отменяем отправку данных формы
    
    })
}



function initFormAjaxTextThis(element){
    $('#'+element).on('beforeSubmit', function () {
        var $yiiform = $(this);
        currentSelect2TagValue($yiiform);
        var formData = new FormData($yiiform[0]);
        // отправляем данные на сервер
        $.ajax({
                type: $yiiform.attr('method'),
                url: $yiiform.attr('action'),
                data: formData,
                dataType : 'text',
                processData: false,
                contentType: false,
                cache: false,
            }
        )
        .done(function(data) {
    
          if(data.success){
            ShowToastOk();
            if(parseInt(data.count)>0){
              $('#book_count').text("Написано слов: "+data.count);
             
            }
          }
            
 
        })
        .fail(function () {
          
        })
    return false; // отменяем отправку данных формы
    
    })
}
</script>