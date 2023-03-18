<div class="groups">
    <div id="this_notes_scena" class="notes" style="max-height: 150px;padding-right: 8px;" data-simplebar data-simplebar-auto-hide="false">
        <div class="groups__items-container">
            <?PHP FOREACH($models as $group):?>
                    <div class="groups-item" data-id="<?=$group->id;?>" data-bs-html="true"  data-bs-toggle="popover" tabindex="0"  data-bs-trigger="focus"  role="button" data-bs-placement="bottom" data-bs-content="<?=$group->getPopover(1);?>">
                    
                            <div class="c_pointer list_note note" data-id="<?=$group->id;?>">
                            <strong><?=$group->name;?></strong>  <br>
                                <?=mb_substr(strip_tags($group->text), 0, 150);?>
                            </div>
                    
                        <i OnClick="UpdateNote(this);" data-id="<?=$group->id;?>" class="bi bi-gear" title="Редактировать"></i>
                        <i OnClick="DeleteNote('<?=$group->id;?>','<?=$group->type;?>','<?=$group->id_target;?>');" class="bi bi-trash" title="Удалить"></i>
                    </div>
            <?PHP ENDFOREACH;?>
            

        </div>
    </div>
    <div class="groups__control">
        <a  OnClick="AddNoteList(this);" data-type="<?=$type;?>" data-target="<?=$scene;?>" class="btn-create">
            <i class="bi bi-plus-circle"></i>Добавить заметку
        </a>
        <a  OnClick="CreateNoteList(this);" data-type="<?=$type;?>" data-target="<?=$scene;?>" class="btn-create">
            <i class="bi bi-plus-circle"></i>Создать заметку
        </a>
    </div>
</div>

