<?php
    $this->title = 'Планирование локаций';
    use app\modules\locations\models\BookLocations;
    use yii\widgets\ActiveForm;
?>
<?php 
  $this->registerJsFile(
    '@web/js/locations.js',
    [
        'position' => $this::POS_HEAD    // подключать в <head>
    ]
  );
?>
<div class="main">
      <div class="container">
        <div class="row">
          <!-- SIDEBAR -->
          <aside class="sidebar sidebar-left filter">
          <div class="border_menu_filter"><img src="/icons/back.png" class="icon_menu_turn"></div>
            <div class="aside__card filter_locations_name">
              <label class="control-label" >Название локации</label>
              <input type="text" class="form-control" id="filter_locations_name" placeholder="Название">
            </div>
            <div class="aside__card filter_locations_id_book">
              <?php $form = ActiveForm::begin(); ?>
              <?= $form->field(new BookLocations(), 'id_book')->dropDownList(BookLocations::getBooks());
              ?>
              <?php ActiveForm::end(); ?>
            </div>
            <div class="aside__card filter_locations_status">
              <?php $form = ActiveForm::begin(); ?>
              <?= $form->field(new BookLocations(), 'status')->dropDownList(BookLocations::getStatus());
              ?>
              <?php ActiveForm::end(); ?>
            </div>
          </aside>
          <!-- CENTER -->
          <!-- CENTER -->
          <div class="col main__center">
            <div class="main__content">
              <article class="article main__article groups">
                <div class="article__title"><?=$this->title;?></div>
                <div id="books_list_items" class="books_list row scenes">
            
                </div>
                <div class="form-group">
                                <a href="/" class="btn c_pointer">Отмена</a>
                                <a href="/master/idea/<?=$book_id;?>/pers" class="btn c_pointer">Назад</a>
                                <a href="/master/<?=$book_id;?>/items" class="btn c_pointer">Далее</a>
                            </div>
              </article>
            </div>
          </div>
         
        </div>
      </div>
    </div>

<script>
    jQuery(document).ready(function ($) {
      getLocations();
      CreateBookLocations();
     });
</script>