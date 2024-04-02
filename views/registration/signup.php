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
                  <small><?=Yii::t('app','Needed to confirm registration and password recovery')?></small>
                  <?= $form->field($model, 'password')->textInput(['autofocus' => true,'placeholder' => 'Пароль'])->passwordInput() ?>
                  <div class="valid_password_line" style="display: none;">
                    <p class="lineght">Пароль должен содержать от 6 символов</p>
                    <p class="abc">Минимум одна буква</p>
                    <p class="caps">Минимум одна заглавная буква</p>
                    <p class="int">Минимум одна цифра</p>
                  </div>
                  <?= $form->field($model, 'repassword')->textInput(['autofocus' => true,'placeholder' => 'Пароль'])->passwordInput() ?>


                  <?= $form->field($model, 'grand')->dropdownList($model->getListGrand())?>
                  <?= $form->field($model, 'verifyCode')->widget(yii\captcha\Captcha::className(),
                      [
                          'captchaAction' => '/registration/captcha',
                          'template' => '<div class="row"><div class="col-xs-3">{image}<p style="margin-top:25px">'.Html::button(Yii::t('app','Refresh captcha'), ['id' => 'refresh-captcha']).'</p></div><div class="col-xs-4"><label class="col-sm-2 col-form-label">'.Yii::t('app','Enter the text from the image').'</label>{input}</div></div>',
                          'imageOptions' => [
                            'id' => 'my-captcha-image'
                          ]
                      ]) ?>
                      <?php $this->registerJs("
                          $('#refresh-captcha').on('click', function(e){
                              e.preventDefault();

                              $('#my-captcha-image').yiiCaptcha('refresh');
                          })
                      "); ?>
                      <?= $form->field($model, 'polit')->checkbox([
                          'template' => "<div>{input} {label}</div>\n<div>{error}</div>",
                      ]) ?>

                  <div class="read">
                    <a href="/docs/term" target="_blank"><?=\Yii::t('app', 'Read Terms of Use');?></a>
                  </div>
                  <div class="read">
                    <a href="/docs/privacy" target="_blank"><?=\Yii::t('app', 'Read Privacy Policy');?></a>
                  </div>
                  <div class="read">
                    <a href="/docs/register" target="_blank"><?=\Yii::t('app', 'Read Disclaimer for Registered Users');?></a>
                  </div>
                  <div class="read">
                    <a href="/docs/unregister" target="_blank"><?=\Yii::t('app', 'Disclaimer for Unregistered Users');?></a>
                  </div>
                  <div class="form-group">
                  <button type="submit" class="btn form-modal__footer-btn">
                    <i class="bi bi-arrow-right-square"></i>Зарегистрироваться
                  </button>
                  </div>


              <?php ActiveForm::end();?>
                      </div>
                    </div>




                </div>
</div>
</div>

