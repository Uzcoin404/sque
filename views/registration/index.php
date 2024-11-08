<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
$this->title = 'Quary';
?>


<div class="container-fluid page__container">

<div class="row page__row">

<div class="col page__col">
<div class="main">

<div id="books_list" class="books_list">
                <div class="row row-cols-2 group-list__row row_main">
                    <div class="col" >
                      <div class="group-card main_page">
                            <div class="group-card__img main-page_logo" >
                            <img src="/icons/logo.png" class="group-card__img main-page_logo">
                            </div>
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
                            
                            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль'])->label() ?>

                            <?= $form->field($model, 'rememberMe')->checkbox([
                                'template' => "<div>{input} {label}</div>\n<div>{error}</div>",
                            ]) ?>

                            <div class="form-group">
                                    <?= Html::submitButton('Войти', ['class' => 'btn form-modal__footer-btn', 'name' => 'login-button']) ?>
                                    <a href="/restore" class="btn_restore">Забыли пароль?</a>
                                    <a href="/registration" class="btn_registrtion">Зарегистрироваться</a>
                            </div>

                        <?php ActiveForm::end();?>
                      
                      </div>
                    </div>
                </div>
</div>
</div>
