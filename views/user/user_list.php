<?php 
    $this->title = \Yii::t('app', 'List users'); 
    use yii\widgets\LinkPager;
?>

<div class="user">
    <div class="user__list">
        <?PHP FOREACH($model as $user):?>
            <?=Yii::$app->controller->renderPartial("_viewUser",["users"=>$user]);?>
        <?PHP ENDFOREACH;?>
    </div>
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>