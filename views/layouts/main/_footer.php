<footer>

        <div class="menu_left__list">
            <div class="menu_left__list_element">
                <ul>
                    <li>
                        <a href="/read">
                            <?=\Yii::t('app', 'Read rules');?>
                        </a>
                    </li>
                    <li>
                        <a href="/privacy">
                            <?=\Yii::t('app', 'Privacy policy');?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>


</footer>
<script>
function AjxFilter(sorts){
    $.post(
        '/question/filter', 
        {
            '".Yii::app()->getRequest()->csrfTokenName."': '".Yii::app()->getRequest()->csrfToken."',
            'sorts': sorts,
        }).done(function (response) {
            response = JSON.parse(response);
           
            if(response.status==1){
                $('.questions.close .questions__list').empty();
                $('.questions.close .questions__list').append(response.result);
            }
         
        }).fail(function(xhr, status, error) {
            console.log('error AjxSetCar');
        });
}
function AjxFilterLike(id, sorts){
    $.post(
        '/like/filterlike', 
        {
            '".Yii::app()->getRequest()->csrfTokenName."': '".Yii::app()->getRequest()->csrfToken."',
            'id': id,
            'sorts': sorts,
        }).done(function (response) {
            response = JSON.parse(response);
           
            if(response.status==1){
                $('.answers_post .answers_post__list').empty();
                $('.answers_post .answers_post__list').append(response.result);
                console.log(response.sort);
            }
         
        }).fail(function(xhr, status, error) {
            console.log('error AjxSetCar');
        });
}
function AjxFilterDislike(id, sorts){
    $.post(
        '/dislike/filterdislike', 
        {
            '".Yii::app()->getRequest()->csrfTokenName."': '".Yii::app()->getRequest()->csrfToken."',
            'id': id,
            'sorts': sorts,
        }).done(function (response) {
            response = JSON.parse(response);
           
            if(response.status==1){
                $('.answers_post .answers_post__list').empty();
                $('.answers_post .answers_post__list').append(response.result);
                console.log(response.sort);
            }
         
        }).fail(function(xhr, status, error) {
            console.log('error AjxSetCar');
        });
}
</script>