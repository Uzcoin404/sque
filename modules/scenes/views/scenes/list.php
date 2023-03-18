<div class="groups__title">Сцены</div>
        <div style="max-height: 150px;padding-right: 8px;" data-simplebar data-simplebar-auto-hide="false">
                <div class="groups__items-container">
                        <?PHP FOREACH($models as $group):?>
                        <div class="groups-item" data-id="<?=$group->id;?>"  >
                                <a  class="list_filter_href" data-bs-html="true" data-bs-toggle="popover" tabindex="0"  data-bs-trigger="focus"  role="button"  data-bs-placement="right" data-bs-content="<?=$group->getPopover(1);?>">
                                
                                <div class="c_pointer list_filter" data-id="<?=$group->id;?>">
                                        <?=$group->name;?>  
                                </div>
                                </a>
                                <a href="/<?=$group->id_book;?>/text/<?=$group->id;?>"><i  class="bi bi-pencil" title="Перейти к сцене"></i></a>
                                <i OnClick="UpdateBookScenes(this);" data-id="<?=$group->id;?>" class="bi bi-gear" title="Редактировать"></i>
                                <i OnClick="DeleteScenesList('<?=$group->id;?>');" class="bi bi-trash" title="Удалить"></i>
                        </div>
                        <?PHP ENDFOREACH;?>
                </div>
        </div>

<div class="groups__control">
    <a onclick="CreateBookScenesList();" class="btn-create"><i class="bi bi-plus-circle"></i>Добавить</a>
</div>
