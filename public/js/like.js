

$(function(){
    $('.answers_post .answers_post__list .answers_post__list_element').each(function(i,element){
        $( element).on("mousemove",function() {
            $(element).attr("data-status",1);
            
          });
    });
});

function VoteSave(){

    var status=[];
    var like=[];
    var like_post=[];
    var dislike_post=[];
    var dislike=[];
    var id_question=[];

    $('.answers_post .answers_post__list .answers_post__list_element[data-status="1"]').each(function(i,element){
        status.push($(element).attr("data-answer-id"));
        id_question.push($(element).attr("data-id-question"));
    });
    $('.answers_post .answers_post__list .answers_post__list_element .btn_like_answer[data-like-status="1"]').each(function(i,element){
        like.push($(element).attr("data-id"));
    });
    $('.answers_post .answers_post__list .answers_post__list_element .btn_dislike_answer[data-dislike-status="1"]').each(function(i,element){
        dislike.push($(element).attr("data-id"));
    });

    $.ajax({
        url: '/like/',
        method: 'get',
        dataType: 'html',
        data: {id_answer_like: like},
        success: function(data){
        }
    })

    $.ajax({
        url: '/dislike/',
        method: 'get',
        dataType: 'html',
        data: {id_answer_dislike: dislike},
        success: function(data){
        }
    })

    $.ajax({
        url: '/viewanswer',
        method: 'get',
        dataType: 'html',
        data: {status_view: status},
        success: function(data){
            window.location.replace("/")
        }
    })
    

}

function SubmitLikeStatus(element){
    $(element).attr('data-like-status', 1);
    $(element).css('height', '30px');
    setTimeout(function(){
        $(element).css('height', '20px');
        $(element).css('background','url(/icons/like_before.png)')
        $('.btn_questions').css('pointer-events', 'auto');
    }, 1000);
}

function SubmitDislikeStatus(element){
    $(element).attr('data-dislike-status', 1);
    $(element).css('height', '30px');
    setTimeout(function(){
        $(element).css('height', '20px');
        $(element).css('background','url(/icons/dislike_before.png)')
        $('.btn_questions').css('pointer-events', 'auto');
    }, 1000);
}

function OpenFullText(element){
    $id = $(element).attr('data-answer-id');
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .opentext').css('display', 'none');
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .closetext').css('display', 'block');
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .text').css('height', 'auto');
}

function CloseFullText(element){
    $id = $(element).attr('data-answer-id');
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .opentext').css('display', 'block');
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .closetext').css('display', 'none');
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .text').css('height', '50px');
}