<?PHP 
    $active="no_active";
    if($element->main==1){
        $active="active";
    }
    $img="";
    if($element->image){
        $img="background:URL('/img/books/".$element->image."')";
    }
?>

<div class="col"  id="book-<?=$element->id;?>" data-index="<?=$dataIndex;?>" data-sort="<?=$element->sort;?>" data-id="<?=$element->id;?>">
        <?= 
            //18-10-2021
            $this->context->renderPartial('_element',["element"=>$element]);
            //18-10-2021
        ?>    
</div>
