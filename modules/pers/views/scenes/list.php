<div class="groups__title">Персонажи</div>
        <div style="max-height: 150px;padding-right: 8px;" data-simplebar data-simplebar-auto-hide="false">
                <div class="groups__items-container">
                        <?PHP FOREACH($models as $group):?>
                        <div class="groups-item">
                                <a class="list_filter_href"  data-bs-html="true" data-bs-toggle="popover" tabindex="0"  data-bs-trigger="focus"  role="button"  data-bs-placement="right" data-bs-content="<?=$group->per->getPopover(1);?>">
                                
                                    <div class="c_pointer list_filter" data-id="<?=$group->per->id;?>">
                                            <?=$group->per->nickname;?>  
                                    </div>
                                </a>
                                <i OnClick="UpdateBookPers('<?=$group->per->id;?>');" class="bi bi-gear" title="Редактировать"></i>
                                <i OnClick="DeletePersScenes('<?=$group->id;?>','<?=$id_scenes;?>');" class="bi bi-trash" title="Удалить"></i>
                        </div>
                        <?PHP ENDFOREACH;?>
                </div>
        </div>

<div class="groups__control">
    <a onclick="CreateBookPersScenes('<?=$id_scenes;?>',1);" class="btn-create"><i class="bi bi-plus-circle"></i>Добавить</a>
</div>


