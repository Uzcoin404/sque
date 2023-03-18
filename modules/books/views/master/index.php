<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;
    $this->title = 'Основная информация';
?>

<div class="main">
      <div class="table">
      
          <!-- SIDEBAR -->
          
          <!-- CENTER -->
          <div class="col main__center">
            <div class="main__content">
              <article class="article main__article">
                <div class="article__title"><?=$this->title;?></div>
                <?php $form = ActiveForm::begin(
                        [
                            'id' => 'book_update',
        
                        ]
                        ); ?>
                      <div class="col-xs-12 col-md-12">
                            <?= $form->field($book, 'name')->textInput(['maxlength' => true,'placeholder' => 'Название книги'])->label() ?>
                      </div>
                      <div class="col-xs-12 col-md-12">
                            <?= $form->field($book, 'genre')->textInput(['maxlength' => true,'placeholder' => 'Жанр'])->label() ?>
                      </div>
                      <div class="col-xs-12 col-md-12">
                          <?= $form->field($book, 'mainpers')->textInput(['maxlength' => true,'placeholder' => 'Персонаж'])->label() ?>
                      </div>
                      <div class="col-xs-12"></div>
                      <div class="col-xs-12 col-md-12">
                        <?= $form->field($book, 'annotation')->textarea(['row' => 9])->label() ?>    
                      </div>
                      <div class="col-xs-12 col-md-12">
                        <?= $form->field($book, 'plan')->textarea(['row' => 9])->label() ?>    

                      </div>

                      <div class="col-xs-12 col-md-12">   
                        <?= $form->field($book, 'situation')->textarea(['row' => 9])->label() ?>

                            
                      </div>
                      <div class="col-xs-12 col-md-12">    
                        <?= $form->field($book, 'target')->textarea(['row' => 9])->label() ?>        
                           
                      </div>
                      <div class="col-xs-12 col-md-12">
                        <?= $form->field($book, 'conflict')->textarea(['row' => 9])->label() ?> 
                      
                      </div>
                      <div class="col-xs-12 col-md-12">
                       <?= $form->field($book, 'crisis')->textarea(['row' => 9])->label() ?> 
                           
                      </div>
                      <div class="col-xs-12 col-md-12">
                        <?= $form->field($book, 'ex_synopsis')->textarea(['row' => 9])->label() ?> 
                         
                      </div>       
                      <div class="col-xs-12">
                        <div class="form-group">
                          <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                        </div>
                      </div>    
                    <?php $form->end(); ?>
                    

                
              </article>
            </div>
          </div>
         
      
      </div>
    </div>
