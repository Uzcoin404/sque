function getBooks(){
    
    var book_filter_name=$('#filter_book_name').val();
    var filter_book_groups=[];
    $('.filter_book_groups .groups-item label.checked').each(function(index,element){
        var id=$(element).attr('data-id');
        filter_book_groups.push(id);
    });

    $.ajax({
            type: "POST",
            url: '/books/filter',
            data:{
                filter_book_groups:filter_book_groups,
                book_filter_name:book_filter_name,
            },

        }
    )
    .done(function(data) {
        $('.books_list').empty();
 
      if(data.success) {
        $('.books_list').append(data.success);
        InitPopover();
        //18-10-2021
        HideElementGroup();
        //18-10-2021
        $('.group-list__row').sortable({
            items: ':not(.new)'
        }).bind('sortupdate', function(e, ui) {
            var oldIndex=parseInt($(ui.item).attr('data-index'));
            var newIndex=parseInt(ui.item.index());
            var offset=newIndex-oldIndex;
            var sortOld=parseInt($(ui.item).attr('data-sort'));
            var sortNew=sortOld+offset;
            SetSort(ui.item,sortNew,sortOld);
        });
        
      }
    })
}

function SetSort(element,newIndex,oldIndex){

    $(element).parent().find('.col:not(.new)').each(function(index,element){
        $(element).attr('data-index',index);
    });
    var id=$(element).attr('data-id');
        $.ajax({
            type: "POST", 
            url: "/books/ajx/sort",
            data:{
                id:id,
                new:newIndex,
                old:oldIndex,
            },
        })

}

function UpdateBook(element,book_id=false){
    if(!book_id)
    book_id=$(element).attr('data-id');
    $.ajax({
            type: "POST", 
            url: '/books/form',
            data:{
                book_id:book_id,
            },

        }
    )
    .done(function(data) {

        $('#updateModal .modal-dialog').empty();
        $('#updateModal .modal-dialog').append(data.success);
            $('#updateModal').modal('show');
            var callbackFunction=function(response){
                getBooksGroupList();
                //18-10-2021
                //getBooks();
                try {
                    response=JSON.parse(response);
                    $('#book-'+response.element).empty().append(response.html);
                    if(response.reload){
                        getBooks();
                    }
                  } catch (err) {
                  
                    console.log(err);
                  
                  }
            
                //18-10-2021
              
            };
            initFormAjax('m_f_book','updateModal',callbackFunction); 
    })
}



function CopyBook(element){
    var book_id=$(element).attr('data-id');
    $.ajax({
            type: "POST", 
            url: '/books/ajx/copy',
            data:{
                id:book_id,
            },

        }
    )
    .done(function(data) {
        
        //18-10-2021
        //getBooks();
        if(data.success>0){
            var copyElement=$(element).parent().parent().parent().parent().parent();
            $(copyElement).append(data.html);
        }
       
        
        //18-10-2021
    })
}



function CreateBook(show=false,group_id=false){
    console.log(1,show);
    $.ajax({
            type: "POST",
            url: '/books/form',
            data:{
                book_id:0,
                group_id:group_id,
            },

        }
    )
    .done(function(data) {

        $('#updateModal .modal-dialog').empty();
        $('#updateModal .modal-dialog').append(data.success);

        if(show)
        {
            $('#updateModal').modal('show');
            var callbackFunction=function(response){
                getBooksGroupList();
               
                //18-10-2021
                // getBooks();
                 try {
                    response=JSON.parse(response);
                    if(response.element && response.html){
                        $('#books_group-'+group_id).append(response.html);
                    }
                    ShowToastOk();
                  } catch (err) { console.log(err);}
               
                //18-10-2021
            };
            initFormAjax('m_f_book','updateModal',callbackFunction);

        }
        
        
    })
}


function SetMainBook(book_id){
    $.ajax(
        {
            type: "POST",
            url: '/books/ajx/setmain/'+book_id,
            data:{
                book:book_id,
            },

        }
    )
    .done(function(data) {
        if(data.success) {
            getBooks();
            UpdateHeader(data.id,data.name);
        }
    })
 }

function DeleteBook(element,hide=0){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    var book_id=$(element).attr('data-id');
    $.ajax(
        {
            type: "POST",
            url: '/books/ajx/delete',
            data:{
                id:book_id,
            },

        }
    )
    .done(function(data) {
        console.log(data);
        if(data.success) {
            if(data.reload){
                location.reload();
            }
            //18-10-2021 
            //getBooks();
            $('#book-'+book_id).remove();
            UpdateHoderRowGroup();
            //18-10-2021 
            if(hide){
                $('#updateModal').modal('hide');
            }
        }
        if(data.mainbook){
            $('#book-'+data.mainbook).find('.group-card').removeClass("no_active").addClass("active");
        }
    })
}

function ActiveBook(book_id){
    $.ajax(
        {
            type: "POST",
            url: '/books/ajx/active/'+book_id,
            data:{
                book:book_id,
            },

        }
    )
    .done(function(data) {
        if(data.success) {
            getBooks();
        }
    })
}

function InitBooksGroups(){
    
    $('.filter_book_groups .groups-item input[type="checkbox"]').on('click', function (e) {
        //$('.aside__more.element .book').removeClass("active");
        $(this).parent().toggleClass('checked');
        getBooks();
    });

}

function getBooksGroupList(){
    $.ajax({
        type: "POST",
        url: '/books/groups/list',
        data:{
            scene_id:0,
        },

    }
    )
    .done(function(data) {
        console.log(data);
    if(data.success) {
        $('.sidebar .filter_book_groups').empty();
        $('.sidebar .filter_book_groups').append(data.success);
        InitBooksGroups();
    }
    });
}

//UpdateLocationGroup

function UpdateBooksGroup(id=0){

    $.ajax({
            type: "POST", 
            url: '/books/groups/form',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        $('#updateModal .modal-dialog').empty();
        $('#updateModal .modal-dialog').append(data.success);
            $('#updateModal').modal('show');
          
            var callbackFunction=function(){
                getBooks();
                getBooksGroupList();
            };
            initFormAjax('m_f_book_s_p','updateModal',callbackFunction);
    })
}
//DeleteLocationGroup
function DeleteBooksGroup(id=0){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    $.ajax({
            type: "POST", 
            url: '/books/groups/delete',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        getBooksGroupList();
        getBooks();
    })
}
//CreateLocationGroups
function CreateBooksGroups(id=0){

    $.ajax({
            type: "POST", 
            url: '/books/groups/form',
            data:{
                id:0,
            },

        }
    )
    .done(function(data) {

        $('#updateModal .modal-dialog').empty();
        $('#updateModal .modal-dialog').append(data.success);
            $('#updateModal').modal('show');
            
            var callbackFunction=function(){
               
                getBooksGroupList();
                getBooks();
            
            };
            initFormAjax('m_f_book_s_p','updateModal',callbackFunction);
        
        
      
    })
}
function SelectOnlyThisBookGroup(search,element){
    element=$(element).parent().find('label');
    $('.'+search+' .groups-item label.checked').not(element).removeClass("checked");
    $(element).toggleClass("checked");
    getBooks();
}

function ClearFilterBooks(search,element){
    $('.'+search+' .groups-item label.checked').removeClass("checked");
    getBooks();
}


