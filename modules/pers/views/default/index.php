<?php
    $this->title = 'Персонажи';
    use yii\widgets\ActiveForm;
    use app\modules\pers\models\BookPers;
    use app\widgets\Notes;
?>
<?php 
  $this->registerJsFile(
    '@web/js/pers.js',
    [
        'position' => $this::POS_HEAD    // подключать в <head>
    ]
  );
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
        <div class="filter">
          <div class="filter__input">
            <i class="bi bi-search"></i>
            <input type="text" name="filter" id="filter_pers_name" placeholder="Имя персонажа">
          </div>
        </div>
          <div class="groups filter_pers_groups">
           

          </div>
      </aside>

      <div class="col page__col">
        <div class="main">
          <div class="sidebar__toggler">
            <i class="bi bi-chevron-double-left" title="Скрыть боковую панель"></i>
          </div>
          <div id="books_list_items" class="books_list pers">
                  
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



    <script>
     jQuery(document).ready(function ($) {
      getPers();
      CreateBookPers();
      getPersGroupList();
     });
</script>