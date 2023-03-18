<?PHP FOREACH($groups as $group):?>
        <div class="group-list">
            <div class="group-list__title">
                <span class="group-list__title-title"><?=$group["group"]->name;?></span>
                    <span style="background-color:#000" class="group-list__title-color-line"></span>
            </div>
                <div class="row row-cols-2 row-cols-md-1 row-cols-lg-2 row-cols-xl-5 group-list__row" <?=$group["group"]->name;?>>
                    <?PHP $dataIndex=1; $show_col=true; FOREACH($group["elements"] as $element):?>   
                        <?= 
                            $this->context->renderPartial('_view',["element"=>$element,'dataIndex'=>$dataIndex,'show_col'=>$show_col]);
                        ?>
                        <?PHP $dataIndex++; ?>
        
                    <?PHP ENDFOREACH;?>
                </div>

                <a class="c_pointer show-more" data-bs-toggle="false">&nbsp</a>
        </div>
<?PHP ENDFOREACH;?>
