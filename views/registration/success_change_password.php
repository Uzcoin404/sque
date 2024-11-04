<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = "Пароль сброшен";
?>


<div class="container-fluid page__container">

  <div class="row page__row">

    <div class="col page__col">
      <div class="main">

        <div id="books_list" class="registration">
          <div class="row row-cols-2 group-list__row row_main">


            <div class="col">
              <div class="group-card main_page">
                <h1>Готово</h1>
                <p>Вы изменили пароль. Пароль отправлен Вам на почту.</p>
                <p>Если письмо не пришло, пожалуйста, проверьте папку “Спам”.</p>
                <p>Если у Вас возникли трудности со сбросом пароля, пожалуйста, свяжитесь с нами по адресу <a href="mailto:qa170524@yahoo.com">qa170524@yahoo.com</a></p>
                <div class="form-group">
                  <a href="/login" class="btn_registrtion">Войти</a>
                </div>
              </div>
            </div>




          </div>
        </div>
      </div>