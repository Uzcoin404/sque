$(function(){
    $('.answers_post .answers_post__list .answers_post__list_element').each(function(i,element){
        $( element).on("mousemove",function() {
            $(element).attr("data-status",1);
          });
    });
});



function VoteSave(question_id){

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
        like.push(
            {
                answer:$(element).attr("data-id"),
                question:question_id,
            }
        );
    });
    $('.answers_post .answers_post__list .answers_post__list_element .btn_dislike_answer[data-dislike-status="1"]').each(function(i,element){
        dislike.push(
            {
                answer:$(element).attr("data-id"),
                question:question_id,
            }
        );
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
        data: {status_view: status, id_questions: id_question},
        success: function(data){
            location.reload();
        }
    })
    

}

function SubmitLikeStatus(element){
    var status=[];
    var like=[];
    var id_question=[];
    var like=[];
    
    // Удаление лайков
    if($(element).hasClass( "active" )){

        $(element).attr('data-like-status', 1);
        $('.answers_post .answers_post__list .answers_post__list_element[data-status="1"]').each(function(i,element){
            status.push($(element).attr("data-answer-id"));
            id_question.push($(element).attr("data-id-question"));
        });
    
        $(element).each(function(i,element){
            like.push(
                {
                    answer:$(element).attr("data-id"),
                    question:id_question,
                    status: $(element).attr('data-like-status'),
                }
            );
        });

        $.ajax({
            url: '/like/',
            method: 'get',
            dataType: 'html',
            data: {id_answer_like: like},
            success: function(data){
                console.log(data);
            }
        })

        $(element).css('height', '30px');
        setTimeout(function(){
            $(element).css('height', '20px');
            $(element).css('background','url(/icons/like.png)')
            $('.btn_questions').css('pointer-events', 'auto');
            $(element).removeClass('active');
        }, 1000);

    } else {
        $(element).attr('data-like-status', 0);
    }

    // Добавление лайков
    if($(element).attr("data-like-status") == 0){

        $('.answers_post .answers_post__list .answers_post__list_element[data-status="1"]').each(function(i,element){
            status.push($(element).attr("data-answer-id"));
            id_question.push($(element).attr("data-id-question"));
        });
    
        $(element).each(function(i,element){
            like.push(
                {
                    answer:$(element).attr("data-id"),
                    question:id_question,
                    status: 0,
                }
            );
        });

        $.ajax({
            url: '/like/',
            method: 'get',
            dataType: 'html',
            data: {id_answer_like: like},
            success: function(data){
                console.log(data);
            }
        })
        $(element).attr('data-like-status', 1);
        $(element).css('height', '30px');
        setTimeout(function(){
            $(element).css('height', '20px');
            $(element).css('background','url(/icons/like_before.png)')
            $('.btn_questions').css('pointer-events', 'auto');
            $(element).addClass('active');
        }, 1000);

    }

    


}

function SubmitDislikeStatus(element){

    var status=[];
    var dislike_post=[];
    var dislike=[];
    var id_question=[];

    if($(element).hasClass('active')){
        $(element).attr('data-dislike-status', 1);

        $('.answers_post .answers_post__list .answers_post__list_element[data-status="1"]').each(function(i,element){
            id_question.push($(element).attr("data-id-question"));
        });
    
        $(element).each(function(i,element){
            dislike.push(
                {
                    answer:$(element).attr("data-id"),
                    question:id_question,
                    status: $(element).attr("data-dislike-status"),
                }
            );
        });
    
        $.ajax({
            url: '/dislike/',
            method: 'get',
            dataType: 'html',
            data: {id_answer_dislike: dislike},
            success: function(data){
                console.log(data);
            }
        })

        $(element).css('height', '30px');
        setTimeout(function(){
            $(element).css('height', '20px');
            $(element).css('background','url(/icons/dislike.png)')
            $('.btn_questions').css('pointer-events', 'auto');
            $(element).removeClass('active');
        }, 1000);
    } else {
        $(element).attr('data-dislike-status', 0);
    }

    if($(element).attr('data-dislike-status') == 0){

        $('.answers_post .answers_post__list .answers_post__list_element[data-status="1"]').each(function(i,element){
            id_question.push($(element).attr("data-id-question"));
        });
    
        $(element).each(function(i,element){
            dislike.push(
                {
                    answer:$(element).attr("data-id"),
                    question:id_question,
                    status: 0,
                }
            );
        });
    
        $.ajax({
            url: '/dislike/',
            method: 'get',
            dataType: 'html',
            data: {id_answer_dislike: dislike},
            success: function(data){
                console.log(data);
            }
        })
    
        $(element).attr('data-dislike-status', 1);
        $(element).css('height', '30px');
        setTimeout(function(){
            $(element).css('height', '20px');
            $(element).css('background','url(/icons/dislike_before.png)')
            $('.btn_questions').css('pointer-events', 'auto');
            $(element).addClass('active');
        }, 1000);

    }



}

function OpenFullText(element){

    var status=[];
    var id_question=[];
    $st = 1;
    $id = $(element).attr('data-answer-id');

    if($(element).attr('data-status-user') == 1){

        $('.answers_post .answers_post__list .answers_post__list_element[data-status="1"]').each(function(i,element){
            status.push($(element).attr("data-answer-id"));
            id_question.push($(element).attr("data-id-question"));
        });
    
        $.ajax({
            url: '/viewanswer',
            method: 'get',
            dataType: 'html',
            data: {status_view: $(element).attr('data-answer-id'), id_question: id_question},
            success: function(data){
                console.log(data);
            }
        })
        
    }

    $.ajax({
        url: '/text',
        method: 'get',
        dataType: 'html',
        data: {id: $id, status: $st},
        success: function(data){
            $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] p.text').append(data);
        }
    })

    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] p.text').empty();
    
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .opentext').css('display', 'none');
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .closetext').css('display', 'block');
}

function CloseFullText(element){
    $st = 0;
    $id = $(element).attr('data-answer-id');
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] p.text').empty();
    $.ajax({
        url: '/text',
        method: 'get',
        dataType: 'html',
        data: {id: $id, status: $st},
        success: function(data){3
            $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] p.text').append(data);
        }
    })
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .opentext').css('display', 'block');
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .closetext').css('display', 'none');
}


function UserBlockLike(element){
    $id = $(element).attr('data-id')
    $.ajax({
        url: '/like_block',
        method: 'get',
        dataType: 'json',
        data: {id_block: $id},
        success: function(data){
            $('.user_block_like').empty();
            $.each(data , function(index, val) { 
                $(element).parent().parent().parent().find('.user_block_like').append('<p>'+val['user']+'</p>')
            });
        }
    })
}



$(window).on( "scroll", function() {
    if($(this).scrollTop()>=200){
        $(".sroll_top a").css('opacity', '1');
    } else {
        $(".sroll_top a").css('opacity', '0');
    }

    
});