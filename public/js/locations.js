
function getLocations(){
    var filter_items_name=$('#filter_locations_name').val();
    var filter_items_groups=[];
    $('.filter_locations_groups .groups-item label.checked').each(function(index,element){
        var id=$(element).attr('data-id');
        filter_items_groups.push(id);
    });
    $.ajax({
            type: "POST",
            url: '/locations/filter',
            data:{
                filter_items_name:filter_items_name,
                filter_items_groups:filter_items_groups,
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
            SetSortLocations(ui.item,sortNew,sortOld);
        });
      }
    });

}

function SetSortLocations(element,newIndex,oldIndex){

    $(element).parent().find('.col:not(.new)').each(function(index,element){
        $(element).attr('data-index',index);
    });
    var id=$(element).attr('data-id');
        $.ajax({
            type: "POST", 
            url: "/locations/ajx/sort",
            data:{
                id:id,
                new:newIndex,
                old:oldIndex,
            },
        })

}

function UpdateBookLocations(element,id=false){
    if(!id){
        id=$(element).attr('data-id');
    }
    $.ajax({
            type: "POST", 
            url: '/locations/form',
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
                getLocationsGroupList();
                //18-10-2021
                //getLocations();
                try {
                    response=JSON.parse(response);
                    $('#location-'+response.element).empty().append(response.html);
                    if(response.reload){
                        getLocations();
                    }
                  } catch (err) {
                  
                    console.log(err);
                  
                  }
            
                //18-10-2021
            };
            initFormAjax('update_location','updateModal',callbackFunction);
            id_target=id;
            type=4;
            getNotes();
    })
}


function CopyBookLocations(element){
    var id=$(element).attr('data-id');

    $.ajax({
            type: "POST", 
            url: '/locations/ajx/copy',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        //18-10-2021
        //getLocations();
        if(data.success>0){
            var copyElement=$(element).parent().parent().parent().parent().parent();
            $(copyElement).append(data.html);
        }
        //18-10-2021
    })
}

function CreateBookLocations(show=false,group_id=false){

    $.ajax({
            type: "POST",
            url: '/locations/form',
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
                getLocationsGroupList();
                //18-10-2021
                // getLocations();
      
                try {

                    response=JSON.parse(response);
                    if(response.element && response.html){
                       if(group_id){
                            $('#location_group-'+group_id).append(response.html);
                       }else{
                        getLocations();
                       }
                    }
                    ShowToastOk();
                  } catch (err) { console.log(err);}
               
                //18-10-2021
            };
            initFormAjax('create_location','updateModal',callbackFunction);
        }
        
    })
}




function DeleteLocations(element,hide=0){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    var id=$(element).attr('data-id');
    $.ajax(
        {
            type: "POST",
            url: '/locations/ajx/delete',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        if(data.success) {
            //18-10-2021 
            //getLocations();
            $('#location-'+id).remove();
            UpdateHoderRowGroup();
            //18-10-2021 
            if(hide){
                $('#updateModal').modal('hide');
            }
        }
    })
}

function ActiveLocations(id){
    $.ajax(
        {
            type: "POST",
            url: '/locations/ajx/active/'+id,
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        if(data.success) {
            getLocations();
        }
    })
}


function getLocationsScenesList(scene_id){
    $.ajax({
        type: "POST",
        url: '/locations/scenes/list',
        data:{
            scene_id:scene_id,
        },

    }
    )
    .done(function(data) {
        $('.sidebar .locations_list').empty();
    if(data.success) {
        
        $('.sidebar .locations_list').append(data.success);
        InitPopover();
    }
    });
}

function CreateBookLocationsScenes(id_scene,show=false){

    $.ajax({
            type: "POST",
            url: '/locations/scenes/form',
            data:{
                id_scene:id_scene,
            },

        }
    )
    .done(function(data) {
    
        $('#updateModal .modal-dialog').empty();
        $('#updateModal .modal-dialog').append(data.success);
        if(show)
        {
            $('#updateModal').modal('show');
            $('#updateModal .close' ).unbind("click");
            $('#updateModal .close' ).on( "click",function(){
                CloseModalForm('create_location_scene','updateModal',false);
            });
            initFormAjaxText('create_location_scene');

        }
        
    })
}

function DeleteLocationsScenes(id_item,id_scenes){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    $.ajax({
        type: "POST",
        url: '/locations/scenes/delete',
        data:{
            id_scenes:id_scenes,
            id_item:id_item,
        },

    }
    )
    .done(function(data) {
        if(data.success) {
            getLocationsScenesList(id_scenes);
        }

    });
}


function InitLocationsGroups(){
    $('.filter_locations_groups .groups-item input[type="checkbox"]').on('click', function (e) {
        //$('.aside__more.element .book').removeClass("active");
        $(this).parent().toggleClass('checked');
        getLocations();
    });

}
//getLocationsGroupList
function getLocationsGroupList(){
    $.ajax({
        type: "POST",
        url: '/locations/groups/list',
        data:{
            scene_id:0,
        },

    }
    )
    .done(function(data) {
    if(data.success) {
        $('.sidebar .filter_locations_groups').empty();
        $('.sidebar .filter_locations_groups').append(data.success);
        InitLocationsGroups();
    }
    });
}

//UpdateLocationGroup

function UpdateLocationGroup(id=0){

    $.ajax({
            type: "POST", 
            url: '/locations/groups/form',
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
                getLocationsGroupList();
                InitLocationsGroups();
            };
            initFormAjax('update_location_group','updateModal',callbackFunction);
            
        
      
    })
}
//DeleteLocationGroup
function DeleteLocationGroup(id=0){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    $.ajax({
            type: "POST", 
            url: '/locations/groups/delete',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        getLocationsGroupList();
        InitLocationsGroups();
        getLocations();
    })
}
//CreateLocationGroups
function CreateLocationGroups(id=0){

    $.ajax({
            type: "POST", 
            url: '/locations/groups/form',
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
                getLocations();
                getLocationsGroupList();
                InitLocationsGroups();
                
            };
            initFormAjax('create_location_group','updateModal',callbackFunction);
        
        
      
    })
}
function SelectOnlyThisLocationsGroup(search,element){
    $('.'+search+' .groups-item label.checked').removeClass("checked");
    $(element).parent().find('label').addClass("checked");
    getLocations();
}

function ClearFilterLocations(search,element){
    $('.'+search+' .groups-item label.checked').removeClass("checked");
    getLocations();
}


function ClearBookLocationsImage(element){
    var id=$(element).attr('data-id');
    if(id<=0){
        $(element).parent().find("[type=file]").val(''); 
        $(element).parent().parent().find(".preview-image").css("background","");
        return 0;
    }
    $.ajax({
            type: "POST", 
            url: '/locations/clearimg',
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


function SaveLocation(form, element){
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
            console.log(data);
            if(data.success>0){
                iniAskSave(form);
                ShowToastOk();
                UpdateBookLocations(false,data.element);
                getLocationsGroupList();
                //18-10-2021
                //getLocations(); 
                if(data.element>0){
                    $('#location-'+data.element).empty().append(data.html);
                }
                if(data.reload){
                    getLocations();
                }
                ask_save_change=false;
                //18-10-2021
            }else{
                ShowToastBad($yiiform);
            }
            ABTN(element,0);
        })
        .fail(function () {
            ABTN(element,0);
        })
    
}

function SaveLocationAndAdd(form,element){
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
                iniAskSave(form);
                CreateBookLocations(1);
                getLocationsGroupList();
                getLocations();
            }
            ABTN(element,0);
        })
        .fail(function () {
            ABTN(element,0);
        })
}