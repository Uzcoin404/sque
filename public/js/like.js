


function LikeSubmit(){
    $key = 'SDbB23X3@FGLbisk%'
    $('.btn_like').prop('disabled', true);
    $('.btn_dislike').prop('disabled', true);
    $('.btn_like').css('height', '30px');
    setTimeout(function(){
        $('.btn_like').css('height', '20px');
        $('.btn_like').css('background','url(/icons/like_before.png)')
        $('.btn_questions').css('pointer-events', 'auto');
    }, 1000);

    $('.btn_questions').each(function(){
        this.href += '?like='+$key+'';
   })
}
function DislikeSubmit(){
    $key = 'SDbB23X3@FGLbisk%'
    $('.btn_dislike').prop('disabled', true);
    $('.btn_like').prop('disabled', true);
    $('.btn_dislike').css('height', '30px');
    setTimeout(function(){
        $('.btn_dislike').css('height', '20px');
        $('.btn_dislike').css('background','url(/icons/dislike_before.png)')
        $('.btn_questions').css('pointer-events', 'auto');
    }, 1000);

    $('.btn_questions').each(function(){
        this.href += '/dislike?dislike='+$key+'';
   })
}