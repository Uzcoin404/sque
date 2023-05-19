<?php 
    $this->title = \Yii::t('app', 'Complaint'); 
    use yii\widgets\LinkPager;
?>
<div class="complaints">
    <div class="complaints__list">
        <?PHP FOREACH($complain as $complaints):?>
            <?=Yii::$app->controller->renderPartial("_viewComplain",["complaints"=>$complaints]);?>
        <?PHP ENDFOREACH;?>
    </div>
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>