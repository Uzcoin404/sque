<div class="questions__filter">
        <div class="questions__filter_form__list">
                <div class="questions__filter_form__list_element">
                  <label for="">
                    <?=\Yii::t('app', 'Date');?>
                  </label>
                  <div class="questions__filter_form__list_element_to">
                    <a class="sort" data-sort="date-ASC"><img src="/img/icons/az.png"></a>
                    <a class="sort" data-sort="date-DESC"><img src="/img/icons/za.png"></a>
                  </div>  
                </div>
                <div class="questions__filter_form__list_element">
                  <label for="">
                    <?=\Yii::t('app', 'Interested users');?>
                  </label>
                  <div class="questions__filter_form__list_element_to">
                    <a class="sort" data-sort="view-DESC"><img src="/img/icons/az.png"></a>
                    <a class="sort" data-sort="view-ASC"><img src="/img/icons/za.png"></a>
                  </div>
                </div>
                <div class="questions__filter_form__list_element">
                  <label for="">
                    <?=\Yii::t('app', 'Count answers');?>
                  </label>
                  <div class="questions__filter_form__list_element_to">
                    <a class="sort" data-sort="answers-DESC"><img src="/img/icons/az.png"></a>
                    <a class="sort" data-sort="answers-ASC"><img src="/img/icons/za.png"></a>
                  </div>
                </div>
                <div class="questions__filter_form__list_element">
                  <label for="">
                    <?=\Yii::t('app', 'Number of participants');?>
                  </label>
                  <div class="questions__filter_form__list_element_to">
                    <a class="sort" data-sort="likes_answer-DESC"><img src="/img/icons/az.png"></a>
                    <a class="sort" data-sort="likes_answer-ASC"><img src="/img/icons/za.png"></a>
                  </div>  
                </div>
                <div class="questions__filter_form__list_element">
                  <a class="btn_filter" OnClick="ApplyFilter();"><?=\Yii::t('app', 'Apply');?></a>
                  <a class="btn_filter reset" OnClick="ResetFilter();"><?=\Yii::t('app', 'Reset');?></a>
                </div>
        </div>
</div>
