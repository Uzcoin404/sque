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