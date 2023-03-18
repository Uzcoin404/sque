<?PHP FOREACH($groups as $group):?>
    <?PHP IF($group["group"]->status):?>
        <div class="group-list">
            <div class="group-list__title">
                <span class="group-list__title-title"><?=$group["group"]->name;?></span>
                    <span style="background-color:<?=$group["group"]->color;?>" class="group-list__title-color-line"></span>
            </div>
                <div id="pers_group-<?=$group["group"]->id;?>" class="row row-cols-2 row-cols-md-1 row-cols-lg-2 row-cols-xl-5 group-list__row">
                    <?= 
                    $this->context->renderPartial('_view_new',["group"=>$group["group"]]);
                    ?>
                    <?PHP $dataIndex=1; FOREACH($group["elements"] as $element):?>   
                        <?= 
                            $this->context->renderPartial('_view',["element"=>$element,'dataIndex'=>$dataIndex]);
                        ?>
                        <?PHP $dataIndex++; ?>
                    <?PHP ENDFOREACH;?>
                </div>
                <a OnClick="ShowGroup(this);" class="c_pointer show-more" data-bs-toggle="false">Показать все</a>
        </div>
    <?PHP ENDIF;?>
<?PHP ENDFOREACH;?>
