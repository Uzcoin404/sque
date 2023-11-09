$(function(){
    $('.questions__filter_form__list_element .questions__filter_form__list_element_to a.sort').each(function(){
        $(this).on( "click", function() {
            if(!$(this).hasClass("active")){
                $(this).parent().find('a.sort').each(function(){
                    $('.questions__filter_form__list_element .questions__filter_form__list_element_to a.sort').removeClass("active");
                });
            }
            $(this).toggleClass("active");
        } );
    });
});

$(document).ready(function(){
    let key = getUrlParameter('sorts');
    if(key){
        $('.questions__filter_form__list_element .questions__filter_form__list_element_to a.sort[data-sort="'+key+'"]').addClass('active');
        $('.questions__filter_form__list_element a.btn_filter.reset').css('display','block');
    }
})

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

function ApplyFilter(element){
    let sorts="?";

    if($(element).hasClass('active')){
        location.replace('/question/filter'+sorts+'');
    } else {
        $(element).each(function(){
            sorts+="sorts="+$(element).attr('data-sort');
        });
        console.log($(element).attr('data-sort')); 
        location.replace('/question/filter'+sorts+'');
    }

 
    return;
    // $("a.btn_filter [data-filter=1]").attr("href", $(this).attr('data-sort'))
    // console.log(sorts);
    // $('.questions__filter_form__list_element a.btn_filter.reset').css('display','block');
}

function ResetFilter(){
    location.reload();
}

