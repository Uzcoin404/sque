$(function(){
    $('.answers_post .answers_post__list .answers_post__list_element').each(function(i,element){
        $( element).on("mousemove",function() {
            $(element).attr("data-status",1);
          });
    });
});

function FilterLike(element){
    $id = $(element).attr('data-id');
    $sorts = $(element).attr('data-sort');
    $(element).addClass('active');
    $('.seacrh_answers.dislike').removeClass('active');
    $('.seacrh_answers.dislike').attr('data-sort','ALL');
    $sorts_true="ALL";
   
    if($sorts){
        if($sorts=="DESC"){
            $(element).attr('data-sort','ALL');
            $(element).removeClass('active');
            $sorts_true="ALL";
        }
        if($sorts=="ALL"){
            $(element).attr('data-sort','DESC');
            $sorts_true="DESC";
        }
    }
    console.log($sorts_true);
    AjxFilterLike($id, $sorts_true);
}

function FilterDislike(element){
    $id = $(element).attr('data-id');
    $sorts = $(element).attr('data-sort');
    $sorts_true="ALL";
    $(element).addClass('active');
    $('.seacrh_answers.like').removeClass('active');
    $('.seacrh_answers.like').attr('data-sort','ALL');
    if($sorts){
        if($sorts=="DESC"){
            $(element).attr('data-sort','ALL');
            $(element).removeClass('active');
            $sorts_true="ALL";
            $('.btn_like_answer').removeClass('active');
            
        }
        if($sorts=="ASC"){
            $(element).attr('data-sort','DESC');
            $sorts_true="DESC";
            $('.btn_dislike_answer.active_true').addClass('active');
        }
        if($sorts=="ALL"){
            $(element).attr('data-sort','DESC');
            $sorts_true="DESC";
            $('.btn_dislike_answer.active_true').addClass('active');
        }
    }
    console.log($sorts_true);
    AjxFilterDislike($id, $sorts_true);
}

function VoteSave(question_id){

    var status=[];
    var like=[];
    var like_post=[];
    var dislike_post=[];
    var dislike=[];
    var question_id=[];

    $('.answers_post .answers_post__list .answers_post__list_element[data-status="1"]').each(function(i,element){
        status.push($(element).attr("data-answer-id"));
        question_id.push($(element).attr("data-id-question"));
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
        data: {status_view: status, question_id: question_id},
        success: function(data){
            location.reload();
        }
    })
    

}

function SubmitLikeStatus(element) {
    
    var status=[];
    var question_id=[];
    var like=[];
    var dislike=[];

    $id = $(element).attr('data-id');
    
    // Удаление лайков
    if($(element).hasClass( "active" )){

        $(element).attr('data-like-status', 1);
        $('.answers_post .answers_post__list .answers_post__list_element[data-status="1"]').each(function(i,element){
            status.push($(element).attr("data-answer-id"));
            question_id.push($(element).attr("data-id-question"));
        });
    
        $(element).each(function (i, element) {
            console.log(element);
            
            like.push(
                {
                    answer:$(element).attr("data-id"),
                    question:question_id,
                    status: $(element).attr('data-like-status'),
                }
            );
        });

        console.log(like);

        $.ajax({
            url: '/like/',
            method: 'get',
            dataType: 'html',
            data: {id_answer_like: like},
            success: function(data){
                
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

    if($('.answers_post .answers_post__list .answers_post__list_element .btn_dislike_answer.block'+$id+'').hasClass('active')){
        $('.answers_post .answers_post__list .answers_post__list_element[data-status="1"]').each(function(i,element){
            question_id.push($(element).attr("data-id-question"));
        });
    
        $(element).each(function(i,element){
            dislike.push(
                {
                    answer:$(element).attr("data-id"),
                    question:question_id,
                    status: 1,
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

        $('.btn_dislike_answer[data-id='+$(element).attr("data-id")+']').css('height', '30px');
        setTimeout(function(){
            $('.btn_dislike_answer[data-id='+$(element).attr("data-id")+']').css('height', '20px');
            $('.btn_dislike_answer[data-id='+$(element).attr("data-id")+']').css('background','url(/icons/dislike_close_no.png)')
            $('.btn_questions').css('pointer-events', 'auto');
            $('.btn_dislike_answer[data-id='+$(element).attr("data-id")+']').removeClass('active');
        }, 1000);
    }

    // Добавление лайков
    if($(element).attr("data-like-status") == 0){

        $('.answers_post .answers_post__list .answers_post__list_element[data-status="1"]').each(function(i,element){
            status.push($(element).attr("data-answer-id"));
            question_id.push($(element).attr("data-id-question"));
        });
    
        $(element).each(function (i, element) {
            console.log(element);
            
            like.push(
                {
                    answer:$(element).attr("data-id"),
                    question:question_id,
                    status: 0,
                }
            );
        });
        console.log(like);
            

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
    var question_id=[];
    var like=[];

    $id = $(element).attr('data-id');
   
    if($(element).hasClass('active')){
        $(element).attr('data-dislike-status', 1);

        $('.answers_post .answers_post__list .answers_post__list_element[data-status="1"]').each(function(i,element){
            question_id.push($(element).attr("data-id-question"));
        });
    
        $(element).each(function(i,element){
            dislike.push(
                {
                    answer:$(element).attr("data-id"),
                    question:question_id,
                    status: 1,
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
            $(element).css('background','url(/icons/dislike_close_no.png)')
            $('.btn_questions').css('pointer-events', 'auto');
            $(element).removeClass('active');
        }, 1000);
        
    } else {
        $(element).attr('data-dislike-status', 0);
    }
    // Если был дизлайк когда стоит лайк
    if($('.answers_post .answers_post__list .answers_post__list_element .btn_like_answer.block'+$id+'').hasClass('active')){
    
        $('.answers_post .answers_post__list .answers_post__list_element[data-status="1"]').each(function(i,element){
            status.push($(element).attr("data-answer-id"));
            question_id.push($(element).attr("data-id-question"));
        });
    
        $(element).each(function(i,element){
            like.push(
                {
                    answer:$(element).attr("data-id"),
                    question:question_id,
                    status: 1,
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

        $('.btn_like_answer[data-id='+$(element).attr("data-id")+']').css('height', '30px');
        setTimeout(function(){
            $('.btn_like_answer[data-id='+$(element).attr("data-id")+']').css('height', '20px');
            $('.btn_like_answer[data-id='+$(element).attr("data-id")+']').css('background','url(/icons/like.png)')
            $('.btn_questions').css('pointer-events', 'auto');
            $('.btn_like_answer[data-id='+$(element).attr("data-id")+']').removeClass('active');
        }, 1000);

    }

    if($(element).attr('data-dislike-status') == 0){

        $('.answers_post .answers_post__list .answers_post__list_element[data-status="1"]').each(function(i,element){
            question_id.push($(element).attr("data-id-question"));
        });
    
        $(element).each(function(i,element){
            dislike.push(
                {
                    answer:$(element).attr("data-id"),
                    question:question_id,
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
            $(element).css('background','url(/icons/dislike_close_no.png)')
            $('.btn_questions').css('pointer-events', 'auto');
            $(element).addClass('active');
        }, 1000);

    }
}

function OpenFullTextClose(element){

    var status=[];
    var question_id=[];
    $st = 1;
    $id = $(element).attr('data-answer-id');

    if($(element).attr('data-status-user') == 1){

        $('.answers_post .answers_post__list .answers_post__list_element[data-status="1"]').each(function(i,element){
            status.push($(element).attr("data-answer-id"));
            question_id.push($(element).attr("data-id-question"));
        });
    
        $.ajax({
            url: '/viewan',
            method: 'get',
            dataType: 'html',
            data: {status_view: $(element).attr('data-answer-id'), question_id: question_id},
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
            $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] p.text').append(data + document.querySelector('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .answers_post__list_element_text_info_btn').innerHTML);
            // $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] p.text').append(
            //     document.querySelector('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .answers_post__list_element_text_info_btn').innerHTML
            // );
            $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] p.text .closetext').css('display', 'inline');
        }
    })

    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] p.text').empty();
    
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .opentext').css('display', 'none');
    // $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .closetext').css('display', 'inline');
    
}



function OpenFullText(element){

    var status=[];
    var question_id=[];
    $st = 1;
    $id = $(element).attr('data-answer-id');

    if($(element).attr('data-status-user') == 1){

        $('.answers_post .answers_post__list .answers_post__list_element[data-status="1"]').each(function(i,element){
            status.push($(element).attr("data-answer-id"));
            question_id.push($(element).attr("data-id-question"));
        });
    
        $.ajax({
            url: '/viewanswer',
            method: 'get',
            dataType: 'html',
            data: {status_view: $(element).attr('data-answer-id'), question_id: question_id, button_click: 1},
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

            $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] p.text').append(data + document.querySelector('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .answers_post__list_element_text_info_btn').innerHTML);
            $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] p.text .closetext').css('display', 'inline');
        }
    })

    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] p.text').empty();
    
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .opentext').css('display', 'none');
    // $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .closetext').css('display', 'block');

    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .closetext').css('display', 'none');
    
    $(element)[0].parentElement.parentElement.cssText = 'flex-direction: column';
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
        success: function(data){
            $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] p.text').append(data);
            
        }
    })
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .closetext').addClass('color_view');
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .opentext').addClass('color_view');
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .opentext').text();
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .opentext').text('Показать весь ответ ещё раз');
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .opentext').css('display', 'block');
    $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .closetext').css('display', 'none');

    // $('.answers_post .answers_post__list .answers_post__list_element[data-answer-id="'+$id+'"] .opentext').css('display', 'none');
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
    });
    $(element).css('display','none');
    $('.btn_like_view.block'+$id+'.close').css('display','inline');
    $('.user_block_like').css('display','flex');
    $('.btn_dislike_view.block'+$id+'.close').css('display','none');
    $('.btn_dislike_view.block'+$id+'.open').css('display','inline');
}


function UserBlockLikeClose(element){
    $('.user_block_like').css('display','none');
    $('.btn_like_view.block'+$id+'.open').css('display','inline');
    $(element).css('display','none');
}

function UserBlockDislike(element){
    $id = $(element).attr('data-id')
    $.ajax({
        url: '/dislike_block',
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
    $(element).css('display','none');
    $('.btn_dislike_view.block'+$id+'.close').css('display','inline');
    $('.user_block_like').css('display','flex');
    $('.btn_like_view.block'+$id+'.close').css('display','none');
    $('.btn_like_view.block'+$id+'.open').css('display','inline');
}

function UserBlockDislikeClose(element){
    $('.user_block_like').css('display','none');
    $('.btn_dislike_view.block'+$id+'.open').css('display','inline');
    $(element).css('display','none');
}


$(window).on( "scroll", function() {
    if($(this).scrollTop()>=200){
        $(".sroll_top a").css('opacity', '1');
    } else {
        $(".sroll_top a").css('opacity', '0');
    }

    
});



(function($) {
	/**
	 * attaches a character counter to each textarea element in the jQuery object
	 * usage: $("#myTextArea").charCounter(max, settings);
	 */

	$.fn.charCounter = function (max, settings) {
		max = max || 100;
		settings = $.extend({
			container: "<p></p>",
			classname: "charcounter",
			format: "%1/"+max+"",
			pulse: true,
			delay: 0
		}, settings);
		var p, timeout;

		function count(el, container) {
			el = $(el);
			if (settings.delay > 0) {
				if (timeout) {
					window.clearTimeout(timeout);
				}
				timeout = window.setTimeout(function () {
					container.html(settings.format.replace(/%1/, (max - el.val().length)));
				}, settings.delay);
			} else {
				container.html(settings.format.replace(/%1/, (el.val().length)));
			}
		};

		function pulse(el, again) {
			if (p) {
				window.clearTimeout(p);
				p = null;
			};
			el.animate({ opacity: 0.1 }, 100, function () {
				$(this).animate({ opacity: 1.0 }, 100);
			});
			if (again) {
				p = window.setTimeout(function () { pulse(el) }, 200);
			};
		};

		return this.each(function () {
			var container;
			if (!settings.container.match(/^<.+>$/)) {
				// use existing element to hold counter message
				container = $(settings.container);
			} else {
				// append element to hold counter message (clean up old element first)
				$(this).next("." + settings.classname).remove();
				container = $(settings.container)
								.insertAfter(this)
								.addClass(settings.classname);
			}
			$(this)
				
				.bind("keydown.charCounter", function () { count(this, container); })
				.bind("keypress.charCounter", function () { count(this, container); })
				.bind("keyup.charCounter", function () { count(this, container); })
				.bind("focus.charCounter", function () { count(this, container); })
				.bind("mouseover.charCounter", function () { count(this, container); })
				.bind("mouseout.charCounter", function () { count(this, container); })
				.bind("paste.charCounter", function () {
					var me = this;
					setTimeout(function () { count(me, container); }, 10);
				});
		
			count(this, container);
		});
	};

})(jQuery);


$("#questions-title").charCounter(5);
$("#questions-text").charCounter(200);
$("#answers-text").charCounter(35);

