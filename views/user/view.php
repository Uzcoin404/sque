<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
?>

<div class="user__list_element">
  <div class="user__list_element_img">

    <p class="title"><?= $users->username ?></p>
  </div>
  <div class="user__list_element_text flex-column align-items-start">
    <a href="mailto:<?= $users->email ?>" class="email"><?= $users->email ?></a>
    <p class="balance">
      <?php
      if (!$users->money) {
        $users->money = 0;
      }
      ?>
      <?= $users->money ?>
    </p>
    <p class="date">
      <?= Yii::t("app", "Date registration") ?>:
      <?php
      $users->create_at = date("d.m.y", $users->create_at);
      ?>
      <?= $users->create_at ?>
    </p>
    <p class="ready">
      <?php
      if ($users->status == 1) {
        $users->status = Yii::t("app", "Accept email");
      } else {
        $users->status = Yii::t("app", "Not accept email");
      }
      ?>
      <?= $users->status ?>
    </p>
    <p class="grand">
      <?php
      if ($users->read == 1) {
        $users->read = Yii::t("app", "Read accept");
      } else {
        $users->read = Yii::t("app", "Read not accept");
      }
      ?>
      <?= $users->read ?>
    </p>
    <p class="id">
      <?= Yii::t("app", "Number user") ?>:
      <?= $users->id ?>
    </p>
    <p class="admin">
      <?php
      if ($users->moderation == 1) {
        $users->moderation = Yii::t("app", "Moderation");
      } else {
        $users->moderation = Yii::t("app", "User");
      }
      ?>
      <?= $users->moderation ?>
    </p>
    <p class="grand mb-2">
      <?php Yii::t("app", "Citizenship"); ?>
      <?= $users->getGrand() ?>
    </p>
    <?php
    $form = ActiveForm::begin([
      'id' => 'user-form',
      'options' => [
        'class' => 'form-modal'
      ],
      // 'action' => "user/$users->id/update",
      'layout' => 'floating',
      // 'fieldConfig' => [
      //   'template' => "{label}\n<div>{input}</div>\n<div>{error}</div>",
      // ],
    ]);
    ?>

    <?= $form->field($users, 'money')->textInput(['placeholder' => 'Edit money'])->label() ?>
    <button type="submit" class="btn btn-outline-primary mt-4 w-100 py-2" name="money-button">Save</button>

    <?php ActiveForm::end(); ?>
  </div>
</div>