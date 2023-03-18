
<?php
use yii\helpers\Html;
use app\modules\chapter\models\BookChapter;
use yii\widgets\ActiveForm;
?>
<div class="modal fade" id="add-chapter" tabindex="-1" role="dialog" aria-labelledby="add-chapter-name">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="add-chapter-name">Создание главы</h4>
      </div>
      <div class="modal-body">
        <p class="msg"></p>
            <?PHP 
                $model_chapter = new BookChapter();
                $model_chapter->id_book=$model->id;
            
            ?>
            <?php $form = ActiveForm::begin(
            [
                'id' => 'chapter_create',
                'action' => '/'.$model->id.'/chapter/create',
                'enableAjaxValidation' => false,
                'validationUrl' => '/'.$model->id.'/chapter/validate',
            ]
            ); ?>

            <?= $form->field($model_chapter, 'name')->textInput(['maxlength' => true,'placeholder' => 'Название главы'])->label() ?>

      
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

          <?php $form->end(); ?>
      </div>

    </div>
  </div>
</div>
