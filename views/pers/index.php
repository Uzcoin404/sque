
<?php
use yii\helpers\Html;
use app\modules\pers\models\BookPers;
use yii\widgets\ActiveForm;
?>


<div class="modal fade" id="add-pers" tabindex="-1" role="dialog" aria-labelledby="add-pers-name">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="add-pers-name">Создание персонажа</h4>
      </div>
      <div class="modal-body">
        <p class="msg"></p>
        <?PHP 
            $model_pers = new BookPers();
            $model_pers->id_book=$model->id;
           
        ?>
         <?php $form = ActiveForm::begin(
           [
            'id' => 'pers_create4',
            'action' => '/'.$model->id.'/pers/create',
            'enableAjaxValidation' => false,
            'validationUrl' => '/'.$model->id.'/pers/validate',
           ]
         ); ?>

            <?= $form->field($model_pers, 'name')->textInput(['maxlength' => true,'placeholder' => 'Имя персонажа'])->label() ?>
            <br><br>
            <?= $form->field($model_pers, 'surname',['inputOptions' => ['id' => 'update-model_pers-surname-']])->textInput(['maxlength' => true])->label() ?>
            <br><br>
            <?= $form->field($model_pers, 'nickname',['inputOptions' => ['id' => 'update-model_pers-nickname-']])->textInput(['maxlength' => true])->label() ?>
            <br><br>
            <?= $form->field($model_pers, 'aliasname',['inputOptions' => ['id' => 'update-model_pers-aliasname-']])->textInput(['maxlength' => true])->label() ?>
            <br><br>
            <?= $form->field($model_pers, 'bod',['inputOptions' => ['id' => 'update-model_pers-bod-']])->textInput(['maxlength' => true,'type' => 'date'])->label() ?>
            <br><br>
            <?= $form->field($model_pers, 'dod',['inputOptions' => ['id' => 'update-model_pers-dod-']])->textInput(['maxlength' => true,'type' => 'date'])->label() ?>
            <br><br>
            <?= $form->field($model_pers, 'old',['inputOptions' => ['id' => 'update-model_pers-old-']])->textInput(['maxlength' => true,'type' => 'number'])->label() ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

          <?php $form->end(); ?>
      </div>

    </div>
  </div>
</div>

