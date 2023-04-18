
    <?PHP  foreach($models as $model):?>
        <?=Yii::$app->controller->renderPartial("//../widgets/views/user/_form_update",["model"=>$model]);?>
    <?PHP ENDFOREACH;?>