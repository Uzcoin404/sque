
<div class="groups__items-container">
    <?PHP FOREACH($models as $group):?>
            <div class="groups-item" data-id="<?=$group->id;?>" data-bs-html="true" data-bs-toggle="popover" tabindex="0"  data-bs-trigger="focus"  role="button"  data-bs-placement="bottom" data-bs-content="<?=$group->getPopover(1);?>">
            
                    <div class="c_pointer list_note note" data-id="<?=$group->id;?>">
                        <strong><?=$group->name;?></strong>  <br>
                        <?=mb_substr(strip_tags($group->text), 0, 150);?>
                    </div>
               
                <i OnClick="UpdateNote(this);" data-id="<?=$group->id;?>" class="bi bi-gear" title="Редактировать"></i>
                <i OnClick="DeleteNote('<?=$group->id;?>','<?=$group->type;?>','<?=$group->id_target;?>');" class="bi bi-trash" title="Удалить"></i>
            </div>
    <?PHP ENDFOREACH;?>

</div>
