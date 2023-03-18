<div class="groups__title">Предметы</div>
        <div style="max-height: 150px;padding-right: 8px;" data-simplebar data-simplebar-auto-hide="false">
                <div class="groups__items-container">
                        <?PHP FOREACH($models as $group):?>
                        <div class="groups-item">
                                <div class="list_filter_href"  data-bs-html="true" data-bs-toggle="popover" tabindex="0"  data-bs-trigger="focus"  role="button"  data-bs-placement="right" data-bs-content="<?=$group->item->getPopover(1);?>">
                                
                                    <div class="c_pointer list_filter" data-id="<?=$group->item->id;?>">
                                            <?=$group->item->name;?>  
                                    </div>
                                </div>
                                <i OnClick="UpdateBookItems('<?=$group->item->id;?>');" class="bi bi-gear" title="Редактировать"></i>
                                <i OnClick="DeleteItemsScenes('<?=$group->id;?>','<?=$id_scenes;?>');" class="bi bi-trash" title="Удалить"></i>
                        </div>
                        <?PHP ENDFOREACH;?>
                </div>
        </div>

<div class="groups__control">
    <a onclick="CreateBookItemsScenes('<?=$id_scenes;?>',1);" class="btn-create"><i class="bi bi-plus-circle"></i>Добавить</a>
</div>
