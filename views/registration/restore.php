<?php


use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Регистрация';

?>


<div class="container-fluid page__container">

<div class="row page__row">

<div class="col page__col">
<div class="main">

<div id="books_list" class="books_list">
                <div class="row row-cols-2 group-list__row row_main">


                    <div class="col" >
                      <div class="group-card main_page">
                      <div class="group-card__title">Восстановление учётной записи</div>
                      <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => [
                        'class' => 'form-modal'
                    ],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div>{input}</div>\n<div>{error}</div>",
                    ],
                ]); ?>

    
                  <?= $form->field($model, 'email')->textInput(['autofocus' => true,'placeholder' => 'email'])->label() ?>
           


                  <div class="form-group">
                    <a onclick="Restore('login-form',this);" class="btn form-modal__footer-btn">
                    <i class="bi bi-arrow-right-square"></i>Отправить новый пароль
                    </a>
                   
                  </div>

              <?php ActiveForm::end();?>
                      </div>
                    </div>




                </div>
</div>
</div>
