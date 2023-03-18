<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>


<div class="container-fluid page__container">

<div class="row page__row">

<div class="col page__col">
<div class="main">

<div id="books_list" class="books_list">
                <div class="row row-cols-2 group-list__row row_main">


                    <div class="col" >
                      <div class="group-card main_page">
                      <h1><?= Html::encode($this->title) ?></h1>
                      <?= nl2br(Html::encode($message)) ?>
                      </div>
                    </div>




                </div>
</div>
</div>
