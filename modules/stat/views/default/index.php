<?php
    $this->title = 'Статистика';
    use yii\widgets\ActiveForm;
    use app\widgets\Notes;
    use app\modules\books\models\Books;
    use yii\helpers\Html;
use kartik\editors\Summernote;
use kartik\select2\Select2;

    $user = Yii::$app->user->identity;
    $active_book=Books::find()->where(
      [
          "id_user"=>$user->id,
          "main"=>1,
          "status"=>1,
      ]
  )->orderBy(["id_group"=>"DESC"])->one();
  if(!isset($active_book->id)) return 0;
?>
<?php 
  $this->registerJsFile(
    '@web/js/stat.js',
    [
        'position' => $this::POS_HEAD    // подключать в <head>
    ]
  );
?>
<?php 
  $this->registerJsFile(
    'https://www.gstatic.com/charts/loader.js',
    [
        'position' => $this::POS_HEAD    // подключать в <head>
    ]
  );
?>
 <?PHP 
                                $all_words=$model->getCountWordsBook();
                                $date_start=$model->getStartDate();
                                $date_end=$model->getBookDateEnd();
                                $date_curent=strtotime("now");
                                $current_day=floor((abs($date_curent - $date_end))/86400)+1;
                                $day_to_this=floor((abs($date_curent - $date_start))/86400)+1;
                                $plan_words=$model->getBookPlanWords();
                                $plan_words_count=0;
                                $fact_words_count=0;
                                $sred_words_count=0;
                                if($current_day>0)
                                  $plan_words_count=floor(($plan_words-$all_words)/$current_day);
                               
                              
                                if($day_to_this>0)
                                  $fact_words_count=floor($all_words/$day_to_this);
                           
                                if($plan_words_count>0){
                                  $sred_words_count=floor(($fact_words_count/$plan_words_count)*100);
                                }
                                if($all_words<=0){
                                  $all_words=0;
                                }
                                if($plan_words<=0){
                                  $plan_words=1;
                                }
                                
                                if($plan_words_count<=0){
                                  $plan_words_count=0;
                                }
                                if($fact_words_count<=0){
                                  $fact_words_count=0;
                                }
                               
                                
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

<div class="col page__col">
<div class="main">

<div id="books_list" class="books_list">
  <div class="row row-cols-1 row-cols-md-2">
                  <div class="col" >
                              <?php $form = ActiveForm::begin(
                                [
                                    'id'=>'m_f_stat',
                                    'action' => '/books/updatestat/'.$active_book->id,
                                    'enableAjaxValidation' => true,
                                    'validationUrl' => '/books/validate',
                                    'fieldConfig' => [
                                      'options' => [
                                          'tag' => false,
                                      ],
                                  ],
                                  ]
                            ); ?>
                              <h3 class="text-left">Цели:</h3>
                              <br>
                              <p>Количество написанных сегодня слов: <?=$model->getCountWordsPerDay();?></p>
                              <p>Количество слов написанных в активной книге: <?=$all_words;?></p>
                              <p>Дата начала работ над книгой: <?= $form->field($active_book, 'date_create')->textInput(['maxlength' => true,'type' => 'date','value'=>date('Y-m-d',$active_book->date_create),'class'=>'stat_input'])->label(false) ?> </p>
                              <p>Планируемая дата окончания книги:  <?= $form->field($active_book, 'date_end')->textInput(['maxlength' => true,'type' => 'date','value'=>date('Y-m-d',$active_book->date_end),'class'=>'stat_input'])->label(false) ?></p>
                              
                              <p>Планируемое количество слов: <?= $form->field($active_book, 'plan_words')->textInput(['maxlength' => true,'type' => 'number','value'=>$plan_words,'class'=>'stat_input'])->label(false) ?></p>
                              <?= $form->field($active_book, 'main')->checkbox(['class'=>'checkbox-main','style'=>"display:none;"],false)->label(false);?>
                              <button type="submit" class="btn form-modal__footer-btn">
                                <i class="bi bi-save"></i>Сохранить
                              </button>
                              
                              
                            <?php ActiveForm::end(); ?>
                  </div>
                  
                  <div class="col" >
                              <h3 class="text-left">Основные показатели:</h3>
                              <br>
                              <p>Целевое количество ежедневно написанных слов: <?=$plan_words_count;?></p>
                              <p>Среднее количество ежедневно написанных слов: <?=$fact_words_count;?></p>
                  </div>
                  

  </div>
  <div class="row row-cols-2 row-cols-md-2">
                  <div class="col" >
                      <div id="piechart" style="width: 100%; height: 500px;"></div>
                  </div>
                  <div class="col" >
                    <div id="words_stat" style="width: 100%; height: 500px;"></div>
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



    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart'], 'language': 'ru'});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        <?PHP
       
          $x_plan=$plan_words-$all_words;
          $z_plan=$plan_words-$x_plan;
          if($x_plan<=0){
            $x_plan=0;
            $z_plan=$all_words;
          }
         
          
        
        ?>
        var data = google.visualization.arrayToDataTable([
          ['Показатель', 'Количество слов'],
          ['Плановое количество слов',     <?=$x_plan;?>],
          ['Фактическое количество слов',      <?=$z_plan;?>],
        ]);

        var options = {
          title: '<?=trim($model->getBookName());?>'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['gauge'], 'language': 'ru'});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Ср. слов', <?=$sred_words_count;?>],
        ]);

        var options = {

        };

        var chart = new google.visualization.Gauge(document.getElementById('words_stat'));

        chart.draw(data, options);
      
    }
    </script>
     <script>
      $(function(){
          $('#m_f_stat').on('beforeSubmit', function () {
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
            ShowToastOk();
            window.location.reload(false);
          })
          .fail(function () {
            
          })
      return false; // отменяем отправку данных формы
      
      })

      });
    </script>