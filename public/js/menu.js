
$(document).ready(function(){
    
    let url = window.location.pathname;
    
    $menu = $('.menu_left__list .menu_left__list_element a').removeClass("active");
    if (url.toLowerCase().indexOf("/questions/close") >= 0){
        url="/questions/close";
    }
    if (url.toLowerCase().indexOf("/questions/view") >= 0){
        url="/";

    }
    if (url.toLowerCase().indexOf("/answer/myanswers") >= 0){
        url="/answer/myanswers";
    }
    if (url.toLowerCase().indexOf("/questions/voting") >= 0){
        url="/questions/voting";

    }
    
    if (url.toLowerCase().indexOf("/questions/myquestions") >= 0){
        url="/questions/myquestions";
    }

    if(url.toLowerCase().indexOf("/questions/myvoiting") >= 0){
        url="/questions/myvoiting";
    }

    if(url.toLowerCase().indexOf("/favourit") >= 0){
        url="/favourit";
    }

    if(url.toLowerCase().indexOf("/question/create") >= 0){
        url="/question/create";

    }

    if(url == "/"){

    }
    
     $('.menu_left__list .menu_left__list_element a[href="'+url+'"]').addClass("active");

     initCookie();
});

function OpenMobileMenu(element){
 
    $(".main_section__left").addClass("active");
    $(element).css("display","none");
    $(".menu_mobile__list_element_control_close").css("display","block")

}

function CloseMobileMenu(element){
    $(element).css("display","none");
    $(".menu_mobile__list_element_control_burger").css("display","block");
    $(".main_section__left").removeClass("active");
    $(".menu_mobile__list_element_control").css("left","-55px");
}


$('#questions-title').on( "click", function(){
    $('.form-group.js-model p').css('display','block');
});

$('#questions-text').on( "click", function(){
    $('.form-group.js-model p').css('display','block');
});

$('#questions-cost').on( "click", function(){
    $('.form-group.js-model p').css('display','block');
});


function initCookie(){
    if ( $.cookie('cookie_accept') == null ) {
        $(".disclaimer").addClass("active");
      }
}

function AccptCookie(){
    $(".disclaimer").removeClass("active");
    $.cookie('cookie_accept', 'value', { expires: 700, path: '/' });
}