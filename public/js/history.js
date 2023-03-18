
function InitHistory(){

    $('.filter_scenes_list .groups-item input[type="checkbox"]').on('click', function (e) {

        $(this).parent().toggleClass('checked');
        getHistory();
    });
    $('#update-scenes-date').change(function() {

        getHistory();
      });
}
function getHistoryScenesList(){
    $.ajax({
            type: "POST",
            url: '/history/scenes/list',
            data:{
                book_id:0,
            },

        }
    )
    .done(function(data) {
      if(data.success) {
         $('.sidebar .filter_scenes_list').empty();
        $('.sidebar .filter_scenes_list').append(data.success);
        InitHistory();

      }
    });

}

function getHistory(){
    var filter_items_name=$('#update-scenes-date').val();
    var filter_items_groups=[];
    $('.filter_scenes_list .groups-item label.checked').each(function(index,element){
        var id=$(element).attr('data-id');
        filter_items_groups.push(id);
    });
    $.ajax({
            type: "POST",
            url: '/history/list',
            data:{
                filter_items_groups:filter_items_groups,
                filter_items_name:filter_items_name,
            
            },

        }
    )
    .done(function(data) {
       
        $('#books_list_items').empty();
      if(data.success) {
        
        $('#books_list_items').append(data.success);
      }
    });

}
function SelectOnlyThisScens(search,element){
    element=$(element).parent().find('label');
    $('.'+search+' .groups-item label.checked').not(element).removeClass("checked");
    $(element).toggleClass("checked");
    getHistory();
}


function ClearFilterHistory(search,element){
    $('.'+search+' .groups-item label.checked').removeClass("checked");
    getHistory();
}