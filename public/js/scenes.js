function getScenes(){
    var filter_items_name=$('#filter_scenes_name').val();
    var filter_items_groups=[];
    $('.filter_scenes_groups .groups-item label.checked').each(function(index,element){
        var id=$(element).attr('data-id');
        filter_items_groups.push(id);
    });
    $.ajax({
            type: "POST",
            url: '/scenes/filter',
            data:{
                filter_items_groups:filter_items_groups,
                filter_items_name:filter_items_name,
            },

        }
    )
    .done(function(data) {
      if(data.success) {
       
         $('.books_list').empty();
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
            SetSortScenes(ui.item,sortNew,sortOld);
        });
      }
    });

}

function SetSortScenes(element,newIndex,oldIndex){

    $(element).parent().find('.col:not(.new)').each(function(index,element){
        $(element).attr('data-index',index);
    });
    var id=$(element).attr('data-id');
        $.ajax({
            type: "POST", 
            url: "/scenes/ajx/sort",
            data:{
                id:id,
                new:newIndex,
                old:oldIndex,
            },
        })

}

function UpdateBookScenes(element,id=false){
    if(!id){
        id=$(element).attr('data-id');
    }
    $.ajax({
            type: "POST", 
            url: '/scenes/form',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {

        $('#updateModal .modal-dialog').empty();
        $('#updateModal .modal-dialog').append(data.success);
            $('#updateModal').modal('show');
            var callbackFunction=function(response){
                getScenesGroupList();
                 //18-10-2021
                //getScenes();
                try {
                    response=JSON.parse(response);
                    $('#scena-'+response.element).empty().append(response.html);
                    if(response.reload){
                        getScenes();
                    }
                  } catch (err) {
                  
                    console.log(err);
                  
                  }
            
                //18-10-2021
            };
            initFormAjax('update_book_scene','updateModal',callbackFunction);
            id_target=id;
            type=2;
            getNotes();
        
      
    })
}

function CopyBookScenes(element){
    var id=$(element).attr('data-id');
    $.ajax({
            type: "POST", 
            url: '/scenes/ajx/copy',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        getScenesList();
        //18-10-2021
        //getScenes();
        if(data.success>0){
            var copyElement=$(element).parent().parent().parent().parent().parent();
            $(copyElement).append(data.html);
        }
        //18-10-2021
      
    })
}


function CreateBookScenes(show=false,group_id=false){

    $.ajax({
            type: "POST",
            url: '/scenes/form',
            data:{
                id:0,
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
            InitPopover();
            var callbackFunction=function(response){
                getScenesGroupList();
               
                //18-10-2021
                //  getScenes();
                try {
                    response=JSON.parse(response);
                    if(response.element && response.html){
                        if(group_id){
                            $('#scena_group-'+group_id).append(response.html);
                        }else{
                            getScenes();
                        }
                    }
                    ShowToastOk();
                  } catch (err) { console.log(err);}
               
                //18-10-2021
            };
            initFormAjax('create_book_scene','updateModal',callbackFunction);

        }
        
    })
}

function CreateBookScenesList(){

    $.ajax({
            type: "POST",
            url: '/scenes/form',
            data:{
                id:0,
            },

        }
    )
    .done(function(data) {

        $('#updateModal .modal-dialog').empty();
        $('#updateModal .modal-dialog').append(data.success);
        $('#updateModal').modal('show');
        initFormAjax('create_book_scene','updateModal',getScenesList);
        InitPopover();

        
    })
}


function DeleteScenesList(id){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    $.ajax(
        {
            type: "POST",
            url: '/scenes/ajx/delete',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        if(data.success) {
            getScenesList();
            try {
                if(id==THIS_SCENES_ID){
                    window.location.href="/scenes/index";
                }
              } catch (err) {
              
                console.log(err);
              
              }

        }
    })
}

function DeleteScenes(element,hide=0){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    var id=$(element).attr('data-id');
    $.ajax(
        {
            type: "POST",
            url: '/scenes/ajx/delete',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        if(data.success) {
             //18-10-2021 
            //getScenes();
            $('#scena-'+id).remove();
            UpdateHoderRowGroup();
            //18-10-2021
            if(hide){
                $('#updateModal').modal('hide');
            }
        }
    })
}

function ActiveScenes(id){
    $.ajax(
        {
            type: "POST",
            url: '/scenes/ajx/active/'+id,
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        if(data.success) {
            getScenes();
        }
    })
}




function getScenesList(){
    $.ajax({
            type: "POST",
            url: '/scenes/scenes/list',
            data:{
                book_id:0,
            },

        }
    )
    .done(function(data) {
      if(data.success) {
         $('.sidebar .scens_list').empty();
        $('.sidebar .scens_list').append(data.success);
        try {
            getActiveSceneList()
        
          } catch (err) {
          
        
          
          }
      }
    });

}



function InitScenesGroups(){
    $('.filter_scenes_groups .groups-item input[type="checkbox"]').on('click', function (e) {
        //$('.aside__more.element .book').removeClass("active");
        $(this).parent().toggleClass('checked');
        getScenes();
    });

}
//getLocationsGroupList
function getScenesGroupList(){
    $.ajax({
        type: "POST",
        url: '/scenes/groups/list',
        data:{
            scene_id:0,
        },

    }
    )
    .done(function(data) {
    if(data.success) {
        $('.sidebar .filter_scenes_groups').empty();
        $('.sidebar .filter_scenes_groups').append(data.success);
        InitScenesGroups();
    }
    });
}

//UpdateLocationGroup

function UpdateScenesGroup(id=0){

    $.ajax({
            type: "POST", 
            url: '/scenes/groups/form',
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
                getScenesGroupList();
                InitScenesGroups();
            };
            initFormAjax('update_book_scene_group','updateModal',callbackFunction);
        
        
      
    })
}
//DeleteLocationGroup
function DeleteScenesGroup(id=0){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    $.ajax({
            type: "POST", 
            url: '/scenes/groups/delete',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        getScenesGroupList();
        InitScenesGroups();
        getScenes();
    })
}
//CreateLocationGroups
function CreateScenesGroups(id=0){

    $.ajax({
            type: "POST", 
            url: '/scenes/groups/form',
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
                getScenes();
                getScenesGroupList();
                InitScenesGroups();
            };
            initFormAjax('create_book_scene_group','updateModal',callbackFunction);
        
        
      
    })
}

function CreateScenesOnHide(form,element){
    ABTN(element,1);
    var $yiiform = $('#'+form);
    currentSelect2TagValue($yiiform);
    ask_save_change=false;
    var formData = new FormData($yiiform[0]);
        $.ajax({
                type: $yiiform.attr('method'),
                url: $yiiform.attr('action'),
                data: formData,
                dataType : 'JSON',
                processData: false,
                contentType: false,
                cache: false,
            }
        )
        .done(function(data) {

            if(data.success>0){
                $('#updateModal').attr('ask-save-element',false);
                $('#updateModal').attr('ask-save-modal',false);
                $('#updateModal').attr('ask-save-callback',false);
                $('#updateModal').attr('ask-save-change',false);
                $('#updateModal').modal('hide');
                window.location.href="/"+data.book_id+"/text/"+data.success;
            }
            ABTN(element,0); 
        })
        .fail(function () {
            ABTN(element,0);
        })
    
}

function CreateScenesAndAdd(form,element){
    ABTN(element,1);
    var $yiiform = $('#'+form);
    currentSelect2TagValue($yiiform);
    var formData = new FormData($yiiform[0]);
        $.ajax({
                type: $yiiform.attr('method'),
                url: $yiiform.attr('action'),
                data: formData,
                dataType : 'JSON',
                processData: false,
                contentType: false,
                cache: false,
            }
        )
        .done(function(data) {
         
            if(data.success>0){
               // $('#updateModal').modal('hide');
                getScenes();
                CreateBookScenes(1);
            }
            ABTN(element,0);
        })
        .fail(function () {
            ABTN(element,0);
        })
}
function SelectOnlyThisScenesGroup(search,element){
    element=$(element).parent().find('label');
    $('.'+search+' .groups-item label.checked').not(element).removeClass("checked");
    $(element).toggleClass("checked");
    getScenes();
}

function ClearFilterScenes(search,element){
    $('.'+search+' .groups-item label.checked').removeClass("checked");
    getScenes();
}

function ClearBookScenesImage(element){
    var id=$(element).attr('data-id');
    if(id<=0){
        $(element).parent().find("[type=file]").val(''); 
        $(element).parent().parent().find(".preview-image").css("background","");
        return 0;
    }
    $.ajax({
            type: "POST", 
            url: '/scenes/clearimg',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        if(data.success){
            $(element).parent().parent().find(".preview-image").css("background","");
        }
    })
}

function SaveScenesAndText(){
    $('#scenes_title').submit();
    $('#scenes_date').submit();
    $('#scenes_text').submit();
    $('#scenes_weather').submit();
    $('#scenes_plan').submit();
    ShowToastOk();
  
}
function SaveScenesAndTextGoMain(){
    $('#scenes_title').submit();
    $('#scenes_date').submit();
    $('#scenes_weather').submit();
    $('#scenes_plan').submit();
    $("#scenes_text").on("submit", function(e){
        e.preventDefault();
        window.location.href="/scenes/index";
    })
    $('#scenes_text').submit();
    
    
    
}

