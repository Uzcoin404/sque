<div class="groups__title">Группы локаций</div>
    <div style="max-height: 150px;padding-right: 8px;" data-simplebar data-simplebar-auto-hide="false">
        <div class="groups__items-container">
        <?PHP FOREACH($models as $group):?>
            <div class="groups-item select_this">
                <label  data-id="<?=$group->id;?>" style="--tooltip-color:<?=$group->color;?>">
                    <input type="checkbox" name="" id="">
                   
                </label>
                <div class="c_pointer list_filter book" data-id="<?=$group->id;?>" OnClick="SelectOnlyThisLocationsGroup('filter_locations_groups',this);">
                        <?=$group->name;?>  
                    </div>
                
                <?PHP IF(!$group->isDefault):?>
                <i OnClick="UpdateLocationGroup('<?=$group->id;?>');" class="bi bi-gear" title="Редактировать"></i>
                <i OnClick="DeleteLocationGroup('<?=$group->id;?>');" class="bi bi-trash" title="Удалить"></i>
                <?PHP ENDIF;?>
            </div>
        <?PHP ENDFOREACH;?>
        </div>
    </div>
<div class="groups__control">
    <a onclick="CreateLocationGroups(1);" class="btn-create"><i class="bi bi-plus-circle"></i>Создать группу</a>
    <a onclick="ClearFilterLocations('filter_locations_groups',this);" class="btn-resert"><i class="bi bi-arrow-repeat"></i>Сбросить фильтры</a>
</div>

