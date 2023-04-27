$(function(){
    $('.questions__filter_form__list_element .questions__filter_form__list_element_to a.sort').each(function(){
        $(this).on( "click", function() {
            if(!$(this).hasClass("active")){
                $(this).parent().find('a.sort').each(function(){
                    $(this).removeClass("active");
                });
            }
            $(this).toggleClass("active");
        } );
    });
});

function ApplyFilter(){
    let sorts=[];
    $('.questions__filter_form__list_element .questions__filter_form__list_element_to a.sort.active').each(function(){
        let sort_type=$(this).attr('data-sort');
        sorts.push(sort_type);
       
    });
    AjxFilter(sorts);
}

