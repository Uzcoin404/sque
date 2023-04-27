<div class="questions__filter">
        <div class="questions__filter_form__list">
                <div class="questions__filter_form__list_element">
                  <label for="">
                    <?=\Yii::t('app', 'Likes');?>
                  </label>
                  <div class="questions__filter_form__list_element_to">
                    <a class="sort" data-sort="likes-ASC"><img src="/img/icons/az.png"></a>
                    <a class="sort" data-sort="likes-DESC"><img src="/img/icons/za.png"></a>
                  </div>  
                </div>
                <div class="questions__filter_form__list_element">
                  <label for="">
                    <?=\Yii::t('app', 'Dislikes');?>
                  </label>
                  <div class="questions__filter_form__list_element_to">
                    <a class="sort" data-sort="dislike-ASC"><img src="/img/icons/az.png"></a>
                    <a class="sort" data-sort="dislike-DESC"><img src="/img/icons/za.png"></a>
                  </div>  
                </div>
                <div class="questions__filter_form__list_element">
                  <label for="">
                    <?=\Yii::t('app', 'Interested users');?>
                  </label>
                  <div class="questions__filter_form__list_element_to">
                    <a class="sort" data-sort="view-ASC"><img src="/img/icons/az.png"></a>
                    <a class="sort" data-sort="view-DESC"><img src="/img/icons/za.png"></a>
                  </div>
                </div>
                <div class="questions__filter_form__list_element">
                  <a class="btn_filter" OnClick="ApplyFilter();"><?=\Yii::t('app', 'Apply');?></a>
                </div>
        </div>
</div>
