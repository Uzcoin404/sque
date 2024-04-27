<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\RegisterAsset;

RegisterAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="wrapper">
        <?= $this->render('free/_header') ?>
    
            <?= $this->render('free/_content',["content"=>$content]) ?>
       
        <?= $this->render('free/_footer') ?>
    </div>
<?php $this->endBody() ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  jQuery(document).ready(function() {
    jQuery('#signupform-grand').select2();
  });

$(function(){
  
    var signupform_password=$('#signupform-password');
    signupform_password.parent().addClass("not_alone");
    signupform_password.parent().prepend("<div class='not_alone_href' OnClick='ShowPassword(this)'><i class='bi bi-eye-slash'></i></div>");
    
  });
  function ShowPassword(element){
    var notVisible = $(element).parent().find("#signupform-password").attr("type");
    if (notVisible === "password") {
      $(element).find(".bi").attr("class", "bi bi-eye");
      $(element).parent().find("#signupform-password").attr("type", "text");
    } else {
      $(element).find(".bi").attr("class", "bi bi-eye-slash");
      $(element).parent().find("#signupform-password").attr("type", "password");
    }

  }
</script>
</body>

</html>
<?php $this->endPage() ?>
