function CreateFavourites(element){
   
    if($(element).attr("data-id-favourite")>0){
        DeleteFavourites(element);
        return;
    }
    $(element).css('height','55px');
   // $(element).prop('disabled', true);
    setTimeout(function(){
        $(element).css('height','50px');
        $(element).css('background', 'url(/icons/star_active_from.png)');
    }, 1000)

    id = [];
    id.push($(element).attr("data-id-question"));

    $.ajax({
        url: '/favourit/create',
        method: 'get',
        dataType: 'json',
        data: {question_id: id},
        success: function(data){
            if(data){
                $(element).attr("data-id-favourite",data);
                
            }
        }
    })
}

function DeleteFavourites(element){

    if($(element).attr("data-id-favourite")<=0){
        CreateFavourites(element);
        return;
    }
    $(element).css('height','55px');
   // $(element).prop('disabled', true);
    setTimeout(function(){
        $(element).css('height','50px');
        $(element).css('background', 'url(/icons/star.png)');
    }, 1000)

    id = [];
    id.push($(element).attr("data-id-favourite"));
    $.ajax({
        url: '/favourit/delete',
        method: 'get',
        dataType: 'html',
        data: {favourite_id: id},
        success: function(data){
            $(element).attr("data-id-favourite",0);
        }
    })
}