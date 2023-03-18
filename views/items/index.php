
<?php
use yii\helpers\Html;
use app\modules\items\models\BookItems;
use yii\widgets\ActiveForm;
?>

<div class="modal fade" id="add-items" tabindex="-1" role="dialog" aria-labelledby="add-items-name">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="add-items-name">Создание предмета</h4>
      </div>
      <div class="modal-body">
        <p class="msg"></p>
        <?PHP 
            $model_items = new BookItems();
            $model_items->id_book=$model->id;
           
        ?>
         <?php $form = ActiveForm::begin(
           [
            'id' => 'items_create5',
            'action' => '/'.$model->id.'/items/create',
            'enableAjaxValidation' => false,
            'validationUrl' => '/'.$model->id.'/items/validate',
           ]
         ); ?>

            <?= $form->field($model_items, 'name')->textInput(['maxlength' => true,'placeholder' => 'Название предмета'])->label() ?>
            <br><br>
            <?= $form->field($model_items, 'description')->textarea(['rows' => '6','placeholder' => 'Описание предмета'])->label(); ?>
      
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

          <?php $form->end(); ?>
      </div>

    </div>
  </div>
</div>


