<?PHP
use app\modules\pers\models\BookPersPers;
?>
<div class="row">
    <div class="col-xs-12">
    <label class="control-label" >Связи персонажа</label>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-6">
        Персонаж
    </div>
    <div class="col-xs-6 col-md-5">
        Тип связи
    </div> 
    <div class="col-xs-6 col-md-1">
    </div>
</div>

<div class="element_pers_list">
<?PHP IF((is_countable($models) && count($models)>0)):?>
    <?PHP FOREACH($models as $model):?>
        <div class="row form perspers" data-id="<?=$model->id;?>" >
        
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <input type="text" value="<?=$model->toIdPers->nickname;?>" data-id="<?=$model->toIdPers->id;?>" class="pers_id">
                    </div>
            
                </div>  
                <div class="col-xs-6 col-md-5">
                    <div class="form-group">
                        <input type="text" value="<?=$model->name;?>"  class="pers_pers_name">
                    </div>
                </div> 
                <div class="col-xs-6 col-md-1">
                    <a onclick="DeletePersPers(this);" data-id="<?=$model->id;?>" class="list__icon del" draggable="false">
                        <i class="bi bi-trash"></i>
                    </a>
                </div> 
        </div>
    <?PHP ENDFOREACH;?>
<?PHP ENDIF;?>
</div>
<div class="row form " hidden>
    
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                <select  class="pers_id">
                            <?PHP FOREACH($BookPersPers->getAllPers() as $key=>$pers):?>
                                <option value="<?=$key;?>"><?=$pers;?></option>
                            <?PHP ENDFOREACH;?>
                    </select>
                </div>  
            </div>  
            <div class="col-xs-6 col-md-5">
                <div class="form-group">
                    <input type="text" value="" class="pers_pers_name">
                </div>
            </div> 
            <div class="col-xs-6 col-md-1">
                <a onclick="DeletePersPers(this);" class="list__icon del" draggable="false">
                    <i class="bi bi-trash"></i>
                </a>
            </div> 
    </div>

<a onclick="AddPersPers(this);" class="list__icon c_pointer" >
    + Добавить связь
</a>