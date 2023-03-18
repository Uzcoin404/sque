<div class="groups__title">Сцены книги</div>
    <div style="max-height: 150px;padding-right: 8px;" data-simplebar data-simplebar-auto-hide="false">
        <div class="groups__items-container">
        <?PHP FOREACH($models as $group):?>
            <div class="groups-item select_this">
                <label  data-id="<?=$group->id;?>">
                    <input type="checkbox" name="" id="" >
                    
                </label>
                <div class="c_pointer list_filter book" data-id="<?=$group->id;?>" OnClick="SelectOnlyThisScens('filter_scenes_list',this);">
                        <?=$group->name;?>  
                    </div>
            </div>
        <?PHP ENDFOREACH;?>
        </div>
    </div>
<div class="groups__control">
    <a onclick="ClearFilterHistory('filter_scenes_list',this);" class="btn-resert"><i class="bi bi-arrow-repeat"></i>Сбросить фильтры</a>
</div>

