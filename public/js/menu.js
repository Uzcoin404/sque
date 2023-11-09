
$(document).ready(function(){
    
    let url = window.location.pathname;

    console.log(url);
    
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

});

function OpenMobileMenu(element){
    var left = 220;
    var z = 999;
    if($( window ).width() >= 400 && $( window ).width() <= 450){
        left = 240;
    }
    if($( window ).width() >= 350 && $( window ).width() <= 400){
        left = 220;
    }
    if($( window ).width() >= 750 && $( window ).width() <= 800){
        left = 480;
        z = 1001;
    }
    if($( window ).width() >= 800 && $( window ).width() <= 830){
        left = 520;
        z = 1001;
    }
    console.log($(window).width())
    $(".main_section__left").css("width","70%");
    $(element).css("display","none");
    $(".menu_mobile__list_element_control_close").css("display","block")
    $(".menu_mobile__list_element_control").css("left",""+left+"px");
    $(".menu_mobile__list_element_control").css("z-index", z);
}

function CloseMobileMenu(element){
    $(element).css("display","none");
    $(".menu_mobile__list_element_control_burger").css("display","block");
    $(".main_section__left").css("width","0px");
    $(".menu_mobile__list_element_control").css("left","-55px");
}


$('#questions-title').on( "click", function(){
    $('.form-group.js-model p').css('display','block');
});

$('#questions-text').on( "click", function(){
    $('.form-group.js-model p').css('display','block');
});

$('#questions-coast').on( "click", function(){
    $('.form-group.js-model p').css('display','block');
});