<?php $this->title = \Yii::t('app', 'Que'); ?>

<div class="complaints">
    <div class="complaints__list">
                    
    
        <?php foreach($model as $value){?>
            <?=Yii::$app->controller->renderPartial("_view",["value"=>$value]);?>
        <?php } ?>
                
            
    </div>
</div>
