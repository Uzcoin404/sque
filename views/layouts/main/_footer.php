<?PHP 

    use app\models\Docs;
?>
<footer>

        <div class="menu_left__list">
            <div class="menu_left__list_element">
                <ul>
                    <li>
                        <a href="/docs/term" target="_blank">
                            <?=\Yii::t('app', 'Terms of Use');?>
                        </a>
                    </li>
                    <li>
                        <a href="/docs/privacy" target="_blank">
                            <?=\Yii::t('app', 'Privacy policy');?>
                        </a>
                    </li>
                    <li>
                        <a href="/docs/register" target="_blank"><?=\Yii::t('app', 'Disclaimer for registered users');?></a>
                    </li>
                    <li>
                        <a href="/docs/unregister" target="_blank"><?=\Yii::t('app', 'Disclaimer for Unregistered Users');?></a>
                    </li>
                </ul>
            </div>
        </div>


</footer>


<div class="disclaimer ">
    <div class="bg"></div>
    <div class="wrapp">
        <div class="title">
            <h2>asdasd</h2>
        </div>
        <div class="body">
            <?= Docs::find()->where(["href"=>"cookie","status"=>1])->one()->text;?>
            
        </div>
        <div class="disclaimer__list_list">
                <a href="/docs/term" target="_blank">
                            <?=\Yii::t('app', 'Terms of Use');?>
                </a>
                <a href="/docs/privacy" target="_blank">
                    <?=\Yii::t('app', 'Privacy policy');?>
                </a>
                <a href="/docs/register" target="_blank"><?=\Yii::t('app', 'Disclaimer for registered users');?></a>
                <a href="/docs/unregister" target="_blank"><?=\Yii::t('app', 'Disclaimer for Unregistered Users');?></a>
        </div>
        <div class="footer">
                <button type="submit" class="btn form-modal__footer-btn" onClick="AccptCookie();">
                    <i class="bi bi-arrow-right-square"></i><?=\Yii::t('app', 'Accept and continue');?>
                  </button>
        </div>
    </div>
</div>

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