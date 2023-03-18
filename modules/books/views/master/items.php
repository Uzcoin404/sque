<?php
    $this->title = 'Планирование предметов';
    use yii\widgets\ActiveForm;
    use app\modules\items\models\BookItems;
?>
<?php 
  $this->registerJsFile(
    '@web/js/items.js',
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
            <div class="aside__card filter_items_name">
              <label class="control-label" >Название предмета</label>
              <input type="text" class="form-control" id="filter_items_name" placeholder="Название">
            </div>
            <div class="aside__card filter_items_id_book">
              <?php $form = ActiveForm::begin(); ?>
              <?= $form->field(new BookItems(), 'id_book')->dropDownList(BookItems::getBooks());
              ?>
              <?php ActiveForm::end(); ?>
            </div>
            <div class="aside__card filter_items_status">
              <?php $form = ActiveForm::begin(); ?>
              <?= $form->field(new BookItems(), 'status')->dropDownList(BookItems::getStatus());
              ?>
              <?php ActiveForm::end(); ?>
            </div>
          </aside>
          <!-- CENTER -->
          <div class="col main__center">
            <div class="main__content">
              <article class="article main__article groups">
                <div class="article__title"><?=$this->title;?></div>
                <div id="books_list_items" class="books_list row items"></div>
                <div class="form-group">
                                <a href="/books" class="btn c_pointer">Готово</a>
                            </div>
              </article>
            </div>
          </div>
         
        </div>
      </div>
    </div>

<script>
     jQuery(document).ready(function ($) {
      getItems();
      CreateBookItems();
     });
</script>