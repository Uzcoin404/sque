<?php
    $this->title = 'Планирование сцен';
    use app\modules\scenes\models\BookScenes;
    use yii\widgets\ActiveForm;
?>
<?php 
  $this->registerJsFile(
    '@web/js/scenes.js',
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
            <div class="aside__card filter_scenes_name">
              <label class="control-label" >Название сцены</label>
              <input type="text" class="form-control" id="filter_scenes_name" placeholder="Название">
            </div>
            <div class="aside__card filter_scenes_id_book">
              <?php $form = ActiveForm::begin(); ?>
              <?= $form->field(new BookScenes(), 'id_book')->dropDownList(BookScenes::getBooks());
              ?>
              <?php ActiveForm::end(); ?>
            </div>
            <div class="aside__card filter_scenes_status">
              <?php $form = ActiveForm::begin(); ?>
              <?= $form->field(new BookScenes(), 'status')->dropDownList(BookScenes::getStatus());
              ?>
              <?php ActiveForm::end(); ?>
            </div>
          </aside>
          <!-- CENTER -->
          <div class="col main__center">
            <div class="main__content">
              <article class="article main__article groups">
                <div class="article__title"><?=$this->title;?></div>
                <div id="books_list_items" class="books_list row scenes">
            
                </div>
                <div class="form-group">
                                <a href="/" class="btn c_pointer">Отмена</a>
                                <a href="/master/idea/<?=$book_id;?>" class="btn c_pointer">Назад</a>
                                <a href="/master/<?=$book_id;?>/pers" class="btn c_pointer">Далее</a>
                            </div>
              </article>
            </div>
          </div>
         
        </div>
      </div>
    </div>

<script>
    jQuery(document).ready(function ($) {
      getScenes();
      CreateBookScenes();
     });
</script>