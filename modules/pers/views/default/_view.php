<div class="col" id="pers-<?=$element->id;?>" data-index="<?=$dataIndex;?>" data-sort="<?=$element->sort;?>" data-id="<?=$element->id;?>">
        <?=     
            //18-10-2021
            $this->context->renderPartial('_element',["element"=>$element]);
            //18-10-2021
        ?>   
</div>
