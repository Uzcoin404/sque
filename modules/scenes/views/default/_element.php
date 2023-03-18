<?PHP 
  $img="background:URL('/img/default/scens.png')";
 if($element->image){
     $img="background:URL('/img/scenes/".$element->image."')";
 }
 ?>

    <div class="group-card">
    <div class="group-card_padding">
        <a class="group-card__img-link">
            <div class="group-card__img" style="<?=$img;?>"></div>
        </a>
        <div class="group-card__title"><?=$element->name;?></div>
         <div class="group-card__btns-block">
            <a onclick="UpdateBookScenes(this)" data-id="<?=$element->id;?>" class="c_pointer group-card__btns-block-link" title="Редактировать">
            <i class="bi bi-gear"></i><span>Редактировать</span>
            </a>
            <a href="/<?=$element->id_book;?>/text/<?=$element->id;?>" class="c_pointer group-card__btns-block-link" title="Писать">
            <i class="bi bi-pencil"></i><span>Писать сцену</span>
            </a>
            <a onclick="CopyBookScenes(this)" data-id="<?=$element->id;?>" class="c_pointer group-card__btns-block-link" title="Копировать">
            <i class="bi bi-files"></i><span>Копировать</span>
            </a>
            <a onclick="DeleteScenes(this);"  data-id="<?=$element->id;?>" class="c_pointer group-card__btns-block-link" title="Удалить">
            <i class="bi bi-trash"></i><span>Удалить</span>
            </a>
        </div>
        <div class="group-card__info">
            <div style="max-height: 150px;padding-right: 8px;" data-simplebar data-simplebar-auto-hide="false">
                <?=$element->getPopover();?>
            </div>
        </div>
    </div>
    </div>

