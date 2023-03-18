<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;
    $this->title = 'Планирование сюжета: Идея';
?>

<div class="main">
      <div class="container">
        <div class="row">
          <!-- SIDEBAR -->
          
          <!-- CENTER -->
          <div class="col main__center">
            <div class="main__content">
              <article class="article main__article">
                <div class="article__title"><?=$this->title;?></div>
                <?php $form = ActiveForm::begin(
                        [
                            'id' => 'book_update_idea',
        
                        ]
                        ); ?>
                        

                            <div class="form-group">
                                <a href="/" class="btn c_pointer">Отмена</a>
                                <a href="/master/<?=$book->id;?>" class="btn c_pointer">Назад</a>
                                <?= Html::submitButton('Далее', ['class' => 'btn btn-success']) ?>
                            </div>

                    <?php $form->end(); ?>
                    

                
              </article>
            </div>
          </div>
         
        </div>
      </div>
    </div>
