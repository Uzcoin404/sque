<div class="questions__filter">
        <div class="questions__filter_form__list">
                <div class="questions__filter_form__list_element">
                  <label for="">
                    <?=\Yii::t('app', 'Coast');?>
                  </label>
                  <div class="questions__filter_form__list_element_to">
                    <a class="sort" data-sort="coast-ASC" OnClick="ApplyFilter(this);"><img src="/img/icons/za.png" style="transform: scale(-1, 1);"></a>
                    <a class="sort" data-sort="coast-DESC" OnClick="ApplyFilter(this);"><img src="/img/icons/az.png" style="transform: scale(-1, 1);"></a>
                  </div>  
                </div>
                <div class="questions__filter_form__list_element">
                  <label for="">
                    <?=\Yii::t('app', 'Interested users');?>
                  </label>
                  <div class="questions__filter_form__list_element_to">
                    <a class="sort" data-sort="view-DESC" OnClick="ApplyFilter(this);"><img src="/img/icons/za.png" style="transform: scale(-1, 1);"></a>
                    <a class="sort" data-sort="view-ASC" OnClick="ApplyFilter(this);"><img src="/img/icons/az.png" style="transform: scale(-1, 1);"></a>
                  </div>
                </div>
                <div class="questions__filter_form__list_element">
                  <label for="">
                    <?=\Yii::t('app', 'Count answers');?>
                  </label>
                  <div class="questions__filter_form__list_element_to">
                    <a class="sort" data-sort="answers-DESC" OnClick="ApplyFilter(this);"><img src="/img/icons/za.png" style="transform: scale(-1, 1);"></a>
                    <a class="sort" data-sort="answers-ASC"  OnClick="ApplyFilter(this);"><img src="/img/icons/az.png" style="transform: scale(-1, 1);"></a>
                  </div>
                </div>
                <div class="questions__filter_form__list_element">
                  <label for="">
                    <?=\Yii::t('app', 'Number of participants');?>
                  </label>
                  <div class="questions__filter_form__list_element_to">
                    <a class="sort" data-sort="likes_answer-DESC" OnClick="ApplyFilter(this);"><img src="/img/icons/za.png" style="transform: scale(-1, 1);"></a>
                    <a class="sort" data-sort="likes_answer-ASC" OnClick="ApplyFilter(this);"><img src="/img/icons/az.png" style="transform: scale(-1, 1);"></a>
                  </div>  
                </div>
               
        </div>
</div>
