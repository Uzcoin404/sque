<footer>
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
</script>