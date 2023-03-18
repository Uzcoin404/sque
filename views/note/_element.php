<div class="group-card">
<div class="group-card_padding">
        <div class="group-card__title">
                <strong><?=$element->name;?></strong>
                <p><?=mb_substr(strip_tags($element->text), 0, 150);?></p>
        </div>
         <div class="group-card__btns-block">
            <a onclick="UpdateNote(this)" data-id="<?=$element->id;?>" data-id_target="<?=$element->id_target;?>" data-type="<?=$element->type;?>" class="c_pointer group-card__btns-block-link" title="Редактировать">
            <i class="bi bi-gear"></i><span>Редактировать</span>
            </a>
            <a onclick="CopyNote(this)" data-id="<?=$element->id;?>" data-id_target="<?=$element->id_target;?>" data-type="<?=$element->type;?>" class="c_pointer group-card__btns-block-link" title="Копировать">
            <i class="bi bi-files"></i><span>Копировать</span>
            </a>
            <a onclick="DeleteNoteNote(this);"  data-id="<?=$element->id;?>" data-id_target="<?=$element->id_target;?>" data-type="<?=$element->type;?>" class="c_pointer group-card__btns-block-link" title="Удалить">
            <i class="bi bi-trash"></i><span>Удалить</span>
            </a>
        </div>
    
    </div>
    </div>