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

                  <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder' => 'Логин'])->label() ?>
                  <?= $form->field($model, 'email')->textInput(['autofocus' => true,'placeholder' => 'Email'])->label() ?>
                  <small>Пожалуйста, убедитесь в правильности введенного Вами адреса электронной почты. На этот адрес Вам будут отправлены ссылка с подтверждением регистрации.</small>
                  <?= $form->field($model, 'password')->textInput(['autofocus' => true,'placeholder' => 'Пароль'])->passwordInput() ?>
                  <div class="valid_password_line" style="display: none;">
                    <p class="lineght">Пароль должен содержать от 6 символов</p>
                    <p class="abc">Минимум одна буква</p>
                    <p class="caps">Минимум одна заглавная буква</p>
                    <p class="int">Минимум одна цифра</p>
                  </div>
                  <?= $form->field($model, 'repassword')->textInput(['autofocus' => true,'placeholder' => 'Пароль'])->passwordInput() ?>
                  <?= $form->field($model, 'grand')->dropdownList($model->getListGrand())?>
                  <label class="col-sm-2 col-form-label recaptc_valid">Введите капчу</label>
                  <div class="form-group">
                    <a onclick="Registration('login-form',this);" class="btn form-modal__footer-btn">
                      <i class="bi bi-arrow-right-square"></i>Зарегистрироваться
                    </a>
                          <small>Нажимая на кнопку регистрации, Вы принимаете <a class="politics" href="">Условия использования</a> и <a class="politics" href="">Политику конфиденциальности</a></small>
                    <a href="/login" class="btn_registrtion">Авторизация</a>
                  </div>


              <?php ActiveForm::end();?>
                      </div>
                    </div>




                </div>
</div>
</div>

<script src="js/validregister.js"> </script>