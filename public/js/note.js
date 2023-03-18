function noteGetNote(){
    var filter_items_name=$('#filter_note_name').val();
    var filter_items_groups=[];
    $('.filter_note_groups .groups-item label.checked').each(function(index,element){
        var id=$(element).attr('data-id');
        filter_items_groups.push(id);
    });
    var filter_items_objects=[];
    $('.filter_note_objects .groups-item label.checked').each(function(index,element){
        var id=$(element).attr('data-id');
        filter_items_objects.push(id);
    });

    $.ajax({
            type: "POST",
            url: '/note/ajx/index',
            data:{
                filter_items_objects:filter_items_objects,
                filter_items_name:filter_items_name,
                filter_items_groups:filter_items_groups,
            
            },

        }
    )
    .done(function(data) {
        console.log(data);
      if(data.success) {
         $('.books_list').empty();
        $('.books_list').append(data.success);
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
            SetSortNote(ui.item,sortNew,sortOld);
        });
      }
    });
}


function SetSortNote(element,newIndex,oldIndex){

    $(element).parent().find('.col:not(.new)').each(function(index,element){
        $(element).attr('data-index',index);
    });
    var id=$(element).attr('data-id');
        $.ajax({
            type: "POST", 
            url: "/note/ajx/sort",
            data:{
                id:id,
                new:newIndex,
                old:oldIndex,
            },
        })

}

function InitScenesType(){
    $('.filter_note_objects .groups-item input[type="checkbox"]').on('click', function (e) {
        //$('.aside__more.element .book').removeClass("active");
        $(this).parent().toggleClass('checked');
        noteGetNote();
    });
    $('.filter_note_groups .groups-item input[type="checkbox"]').on('click', function (e) {
        //$('.aside__more.element .book').removeClass("active");
        $(this).parent().toggleClass('checked');
        noteGetNote();
    });
}

function getNoteGroupList(){
    $.ajax({
        type: "POST",
        url: '/note/groups/list',
        data:{
            scene_id:0,
        },

    }
    )
    .done(function(data) {
    if(data.success) {
        $('.filter_note_groups').empty();
        $('.filter_note_groups').append(data.success);
        InitScenesType();
    }
    });
}

function UpdateNoteGroup(element){
    var id=$(element).attr('data-id');
    $.ajax({
            type: "POST", 
            url: '/note/groups/form',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        $('#updateModal .modal-dialog').empty();
        $('#updateModal .modal-dialog').append(data.success);
            $('#updateModal').modal('show');
            initFormAjax('note_update_group','updateModal',getNoteGroupList);
    })
}

function DeleteNoteGroup(element){

    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    var id=$(element).attr('data-id');
    $.ajax({
            type: "POST", 
            url: '/note/groups/delete',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        getNoteGroupList();
        noteGetNote();
    })
}

function CreateNoteGroups(){

    $.ajax({
            type: "POST", 
            url: '/note/groups/form',
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
                try {
                    getNoteGroupList();
                    noteGetNote();
                    getPers();
                } catch (error) {
                    
                }
              
            };
            initFormAjax('note_create_group','updateModal',callbackFunction);
        
        
      
    })
}
function SelectOnlyThisNoteGroup(search,element){
    element=$(element).parent().find('label');
    $('.'+search+' .groups-item label.checked').not(element).removeClass("checked");
    $(element).toggleClass("checked");
    noteGetNote();
}

function ClearFilterNotes(search,element){
    $('.'+search+' .groups-item label.checked').removeClass("checked");
    noteGetNote();
}

function DeleteNoteNote(element){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    var id=$(element).attr('data-id');
    $.ajax({
        type: "POST",
        url: '/notes/delete/'+id,
        data:{
            id:id,
        
        },

        }
    )
    .done(function(data) {
        if(data.success) {
            $('#noteModal').modal('hide');
            id_target=$(element).attr('data-id_target');
            type=$(element).attr('data-type');
             //18-10-2021 
            //getNotes();
            $('#note-'+id).remove();
            UpdateHoderRowGroup();
            //18-10-2021 
            getScenesNote();
            getNoteGroupList();
            noteGetNote();
        }
    });
}

function CopyNote(element){
    var id=$(element).attr('data-id');
    $.ajax({
        type: "POST",
        url: '/note/ajx/copy',
        data:{
            id:id,
        
        },

        }
    )
    .done(function(data) {
        if(data.success) {
            $('#noteModal').modal('hide');
            id_target=$(element).attr('data-id_target');
            type=$(element).attr('data-type');
            getNotes();
            getScenesNote();
            getNoteGroupList();
            //18-10-2021
            //noteGetNote();
            if(data.success>0){
                var copyElement=$(element).parent().parent().parent().parent().parent();
                $(copyElement).append(data.html);
            }
            //18-10-2021
        }
    });
}