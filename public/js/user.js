$(document).ready(function(){
    
});

function FormImgSubmit(){
    $('.form_img').css('display','flex');
    $('.form_img').css('height','100vh');
}

function FormImgClose(){
    $('.form_img').css('display','none');
    $('.form_img').css('height','0vh');
}


function UserInfo(element, status){

    $id_user = $(element).attr('data-id');

    $.ajax({
        url: '/user/info',
        method: 'get',
        dataType: 'html',
        data: {id_user: $id_user},
        success: function(data){
            data = JSON.parse(data);
            if(status){
                $('.question_post_list_element_user_info[data-id='+$id_user+'] p span').empty();
                $('.question_post_list_element_user_info[data-id='+$id_user+'] p.date span').append(data['date']);
                $('.question_post_list_element_user_info[data-id='+$id_user+'] p.question span').append(data['questions_count']);
                $('.question_post_list_element_user_info[data-id='+$id_user+'] p.answers_info span').append(data['answers_count']);
                $('.question_post_list_element_user_info[data-id='+$id_user+'] p.like_info span').append(data['like_count']);
                $('.question_post_list_element_user_info[data-id='+$id_user+'] p.dislike_info span').append(data['dislike_count']);     
                $('.question_post_list_element_user_info[data-id='+$id_user+'] p.action span').append(data['date_online']); 
            } else {
                $('.ansers_post_list_element_user_info[data-id='+$id_user+'] p span').empty();
                $('.ansers_post_list_element_user_info[data-id='+$id_user+'] p.date span').append(data['date']);
                $('.ansers_post_list_element_user_info[data-id='+$id_user+'] p.question span').append(data['questions_count']);
                $('.ansers_post_list_element_user_info[data-id='+$id_user+'] p.answers span').append(data['answers_count']);
                $('.ansers_post_list_element_user_info[data-id='+$id_user+'] p.like span').append(data['like_count']);
                $('.ansers_post_list_element_user_info[data-id='+$id_user+'] p.dislike span').append(data['dislike_count']);     
                $('.ansers_post_list_element_user_info[data-id='+$id_user+'] p.action span').append(data['date_online']); 
            }
      
        }
    });

    if(status){
        if($('.question_post_list_element_user_info[data-id='+$id_user+']').hasClass('active')){

            $('.question_post_list_element_user_info[data-id='+$id_user+']').removeClass('active');
    
        } else {
            document.querySelectorAll('.question_post_list_element_user_info').forEach(el => {
                el.classList.remove('active');
            });
            document.querySelectorAll('.ansers_post_list_element_user_info').forEach(el => {
                el.classList.remove('active');
            });
            $('.question_post_list_element_user_info[data-id='+$id_user+']').addClass('active');
    
        }
    } else {
        if($('.ansers_post_list_element_user_info[data-id='+$id_user+']').hasClass('active')){

            $('.ansers_post_list_element_user_info[data-id='+$id_user+']').removeClass('active');
    
        } else {
            document.querySelectorAll('.question_post_list_element_user_info').forEach(el => {
                el.classList.remove('active');
            });
            document.querySelectorAll('.ansers_post_list_element_user_info').forEach(el => {
                el.classList.remove('active');
            });
            $('.ansers_post_list_element_user_info[data-id='+$id_user+']').addClass('active');
    
        }
    }


    
}