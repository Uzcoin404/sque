
<div class="col history" data-index="<?=$dataIndex;?>"  data-id="<?=$element->id;?>">
    <div class="group-card">
    <div class="group-card_padding">
        <a class="group-card__title" href="/text/<?=$element->id;?>" target="_blank"  data-id="<?=$element->id;?>" >
                <?=date('d-m-y',$element->date);?>
                <br><br>
                <p><?=strip_tags($element->text);?></p>
        </a>
        
    </div>
    </div>
</div>

