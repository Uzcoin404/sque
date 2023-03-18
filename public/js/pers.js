function getPers(){
    var filter_items_name=$('#filter_pers_name').val();
    var filter_items_groups=[];
    $('.filter_pers_groups .groups-item label.checked').each(function(index,element){
        var id=$(element).attr('data-id');
        filter_items_groups.push(id);
    });
    $.ajax({
            type: "POST",
            url: '/pers/filter',
            data:{
                filter_items_groups:filter_items_groups,
                filter_items_name:filter_items_name,
            
            },

        }
    )
    .done(function(data) {
        console.log(data);
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
            SetSortPers(ui.item,sortNew,sortOld);
        });
      }
    });
 
}

function SetSortPers(element,newIndex,oldIndex){

    $(element).parent().find('.col:not(.new)').each(function(index,element){
        $(element).attr('data-index',index);
    });
    var id=$(element).attr('data-id');
        $.ajax({
            type: "POST", 
            url: "/pers/ajx/sort",
            data:{
                id:id,
                new:newIndex,
                old:oldIndex,
            },
        })

}

function UpdateBookPers(element,id=false){
    if(!id){
        id=$(element).attr('data-id');
    }
    $.ajax({
            type: "POST", 
            url: '/pers/form',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        $('#updateModal .modal-dialog').empty();
        $('#updateModal .modal-dialog').append(data.success);
            $('#updateModal').modal('show');
            initrelatives_add(id);
            $('#update-model-bod-').inputmask("99.99.9999"); 
            $('#update-model-dod-').inputmask("99.99.9999"); 
            var callbackFunction=function(){
                getPersGroupList();
                
            };
            var callbackFunctionSavePersPers=function(response){
                SavePersPers(callbackFunction);
                //18-10-2021
                //getPers();
                try {
                    response=JSON.parse(response);
                    $('#pers-'+response.element).empty().append(response.html);
                    if(response.reload){
                        getPers();
                    }
                  } catch (err) {
                  
                    console.log(err);
                  
                  }
            
                //18-10-2021
            };
            
            initFormAjax('update_pers','updateModal',callbackFunctionSavePersPers);
            id_target=id;
            type=3;
            getNotes();
            console.log(id_target);
      
    })
}
function CopyBookPers(element){
    var id=$(element).attr('data-id');

    $.ajax({
            type: "POST", 
            url: '/pers/ajx/copy',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        //18-10-2021
        //getPers();
        if(data.success>0){
            var copyElement=$(element).parent().parent().parent().parent().parent();
            $(copyElement).append(data.html);
        }
        //18-10-2021
      
    })
}

function CreateBookPers(show=false,group_id=false){

    $.ajax({
            type: "POST",
            url: '/pers/form',
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
            $('#update-model-bod-').inputmask("99.99.9999"); 
            $('#update-model-dod-').inputmask("99.99.9999"); 
            InitPopover();
            var callbackFunction=function(response){
                getPersGroupList();
                //18-10-2021
                // getPers();
                try {
                    response=JSON.parse(response);
                    if(response.element && response.html){
                        if(group_id){
                            $('#pers_group-'+group_id).append(response.html);
                        }else{
                            getPers();
                        }
                    }
                    ShowToastOk();
                  } catch (err) { console.log(err);}
               
                //18-10-2021
            };
            initFormAjax('create_pers','updateModal',callbackFunction);

        }
        
    })
}

function initrelatives_add(){
    getPersPers();
}


function DeletePers(element,hide=0){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    var id=$(element).attr('data-id');
    $.ajax(
        {
            type: "POST",
            url: '/pers/ajx/delete',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        if(data.success) {
            //18-10-2021 
            //getPers();
            console.log(id);
            $('#pers-'+id).remove();
            UpdateHoderRowGroup();
            //18-10-2021
            if(hide){
                $('#updateModal').modal('hide');
            }
        }
    })
}

function ActivePers(id){
    $.ajax(
        {
            type: "POST",
            url: '/pers/ajx/active',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        if(data.success) {
            getPers();
        }
    })
}


function getPersList(scene_id){
    $.ajax({
        type: "POST",
        url: '/pers/scenes/list',
        data:{
            scene_id:scene_id,
        },

    }
    )
    .done(function(data) {
        $('.sidebar .pers_list').empty();
    if(data.success) {
        
        $('.sidebar .pers_list').append(data.success);
        InitPopover();


    }
    });
}

function CreateBookPersScenes(id_scene,show=false){

    $.ajax({
            type: "POST",
            url: '/pers/scenes/form',
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
                CloseModalForm('create_pers_scene','updateModal',false);
            });
            initFormAjaxText('create_pers_scene');

        }
        
    })
}


function DeletePersScenes(id_item,id_scenes){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    $.ajax({
        type: "POST",
        url: '/pers/scenes/delete',
        data:{
            id_scenes:id_scenes,
            id_item:id_item,
        },

    }
    )
    .done(function(data) {
        if(data.success) {
            getPersList(id_scenes);
        }

    });
}



function InitPersGroups(){
    $('.filter_pers_groups .groups-item input[type="checkbox"]').on('click', function (e) {
        //$('.aside__more.element .book').removeClass("active");
        $(this).parent().toggleClass('checked');
        getPers();
    });
    
}
//getLocationsGroupList
function getPersGroupList(){
    $.ajax({
        type: "POST",
        url: '/pers/groups/list',
        data:{
            scene_id:0,
        },

    }
    )
    .done(function(data) {
        console.log(data);
    if(data.success) {
        $('.sidebar .filter_pers_groups').empty();
        $('.sidebar .filter_pers_groups').append(data.success);
        InitPersGroups();
    }
    });
}

//UpdateLocationGroup

function UpdatePersGroup(id=0){

    $.ajax({
            type: "POST", 
            url: '/pers/groups/form',
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
                getPersGroupList();
                InitPersGroups()
                getPers();
            };
            initFormAjax('update_pers_group','updateModal',callbackFunction);
        
        
      
    })
}
//DeleteLocationGroup
function DeletePersGroup(id=0){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    $.ajax({
            type: "POST", 
            url: '/pers/groups/delete',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        getPersGroupList()
        InitPersGroups();
        getPers();
    })
}
//CreateLocationGroups
function CreatePersGroups(id=0){

    $.ajax({
            type: "POST", 
            url: '/pers/groups/form',
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
                getPers();
                getPersGroupList();
                InitPersGroups();
                
            };
            initFormAjax('create_pers_group','updateModal',callbackFunction);
        
        
      
    })
}
function SelectOnlyThisPersGroup(search,element){
    element=$(element).parent().find('label');
    $('.'+search+' .groups-item label.checked').not(element).removeClass("checked");
    $(element).toggleClass("checked");
    getPers();
}
function ClearFilterPers(search,element){
    $('.'+search+' .groups-item label.checked').removeClass("checked");
    getPers();
}

function ClearBookPersImage(element){
    var id=$(element).attr('data-id');
    if(id<=0){
        $(element).parent().find("[type=file]").val(''); 
        $(element).parent().parent().find(".preview-image").css("background","");
        return 0;
    }
    $.ajax({
            type: "POST", 
            url: '/pers/clearimg',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        console.log(data);
        if(data.success){
            $(element).parent().parent().find(".preview-image").css("background","");
        }
    })
}


function SavePers(form,element){
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
                var callbackFunction=function(){
                    ShowToastOk();
                    UpdateBookPers(false,data.element);
                    getPersGroupList();
                    //18-10-2021
                    //getPers(); 
                    if(data.element>0){
                        $('#pers-'+data.element).empty().append(data.html);
                    }
                    if(data.reload){
                        getPers();
                    }
                    ask_save_change=false;
                    //18-10-2021
                };
                SavePersPers(callbackFunction);
            }else{
                
                ShowToastBad($yiiform);
            }
            ABTN(element,0);
        })
        .fail(function () {
            ABTN(element,0);
        })
    
}

function SavePersAndAdd(form, element){
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
                var callbackFunction=function(){
                    CreateBookPers(1);
                    getPersGroupList();
                    getPers();
                };
                SavePersPers(callbackFunction);
            }else{
                ShowToastBad($yiiform);
            }
            ABTN(element,0);
        })
        .fail(function () {
            ABTN(element,0);
        })
}
function AddPersPers(){
    $('#parents_add [hidden]').clone(true,true).appendTo( ".element_pers_list" ).removeAttr("hidden").addClass("perspers");
}
function getPersPers(){
    var id_pers=$('#parents_add').attr('data-id');
    console.log(id_pers);
    $.ajax({
        type: "POST",
        url: '/pers/pers/list',
        data:{
            id_pers:id_pers,
        
        },

        }
    )
    .done(function(data) {
    if(data.success) {
        $('#parents_add').empty();
        $('#parents_add').append(data.success);
    
    }
    });
}

function DeletePersPers(element){
    $(element).parent().parent().remove()
}

function SavePersPers(callbackFunction){

    let perspers= [];
    $('#parents_add .element_pers_list .perspers').each(function(index,element){
        if($(element).attr('data-id')){
            perspers.push(
                {
                    pers_id: $(element).find('.pers_id').attr('data-id'),
                    name:  $(element).find('.pers_pers_name').val(),
                }
            );
        }else{
            perspers.push(
                {
                    pers_id: $(element).find('.pers_id').val(),
                    name:  $(element).find('.pers_pers_name').val(),
                }
            );
        }
       
    });
    console.log(perspers);
    $.ajax({
        type: "POST",
        url: '/pers/pers/save',
        data:{
            id_pers:$('#parents_add').attr('data-id'),
            perspers: perspers,
        
        },

        }
    )
    .done(function(data) {
        if(data.success) {
            callbackFunction();
        
        }
    });
    
}