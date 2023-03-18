
<?php
use yii\helpers\Html;
use app\modules\locations\models\BookLocations;
use yii\widgets\ActiveForm;
?>
<div class="modal fade" id="add-locations" tabindex="-1" role="dialog" aria-labelledby="add-locations-name">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="add-locations-name">Создание локации</h4>
      </div>
      <div class="modal-body">
        <p class="msg"></p>
            <?PHP 
                $model_locations = new BookLocations();
                $model_locations->id_book=$model->id;
            
            ?>
            <?php $form = ActiveForm::begin(
            [
                'id' => 'locations_create4',
                'action' => '/'.$model->id.'/locations/create',
                'enableAjaxValidation' => false,
                'validationUrl' => '/'.$model->id.'/locations/validate',
            ]
            ); ?>

                <?= $form->field($model_locations, 'name')->textInput(['maxlength' => true,'placeholder' => 'Название локации'])->label() ?>
                <br><br>
                <?= $form->field($model_locations, 'description')->textarea(['rows' => '6','placeholder' => 'Описание локации'])->label(); ?>
        
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>

            <?php $form->end(); ?>
      </div>

    </div>
  </div>
</div>


