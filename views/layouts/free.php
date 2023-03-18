<?php
use yii\helpers\Html;
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
    <link href="/css/simplebar.css" rel="stylesheet">
    <link href="/css/jquery.formstyler.css" rel="stylesheet">
    <link href="/css/jquery.formstyler.theme.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

        <div class="page login">
            <?= $content ?>
        </div>
        <div class="main-footer-free">
                                <!-- <a href="/Terms_of_use.pdf">Пользовательское соглашение</a> |
                                <a href="/Privacy_Policy.pdf">Политика конфиденциальности</a> -->
                        </div>
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
        <script src="/js/simplebar.js"></script>
        <script src="/js/bootstrap.bundle.min.js"></script>
        <script src="/js/all.js"></script>
</body>
</html>
<?php $this->endPage() ?>