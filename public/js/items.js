function getItems(){
    var filter_items_name=$('#filter_items_name').val();
    var filter_items_groups=[];
    $('.filter_items_groups .groups-item label.checked').each(function(index,element){
        var id=$(element).attr('data-id');
        filter_items_groups.push(id);
    });
    $.ajax({
            type: "POST",
            url: '/items/filter',
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
            SetSortItems(ui.item,sortNew,sortOld);
        });
      }
    });
  
}

function SetSortItems(element,newIndex,oldIndex){

    $(element).parent().find('.col:not(.new)').each(function(index,element){
        $(element).attr('data-index',index);
    });
    var id=$(element).attr('data-id');
        $.ajax({
            type: "POST", 
            url: "/items/ajx/sort",
            data:{
                id:id,
                new:newIndex,
                old:oldIndex,
            },
        })

}

function UpdateBookItems(element,id=false){
    if(!id){
        id=$(element).attr('data-id');
    }

    $.ajax({
            type: "POST", 
            url: '/items/form',
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
                getItemsGroupList();
                //18-10-2021
                //getItems();
                try {
                    response=JSON.parse(response);
                    $('#item-'+response.element).empty().append(response.html);
                    if(response.reload){
                        getItems();
                    }
                  } catch (err) {
                  
                    console.log(err);
                  
                  }
            
                //18-10-2021
            };
            initFormAjax('update_item','updateModal',callbackFunction);
            id_target=id;
            type=5;
            getNotes();
        
      
    })
}

function CopyBookItems(element){
    var id=$(element).attr('data-id');

    $.ajax({
            type: "POST", 
            url: '/items/ajx/copy',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {     
        //18-10-2021
        //getItems();
        if(data.success>0){
            var copyElement=$(element).parent().parent().parent().parent().parent();
            $(copyElement).append(data.html);
        }
        //18-10-2021
    })
}


function CreateBookItems(show=false,group_id=false){

    $.ajax({
            type: "POST",
            url: '/items/form',
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
                getItemsGroupList();
                //18-10-2021
                // getItems();
                try {
                    response=JSON.parse(response);
                    if(response.element && response.html){
                        if(group_id){
                            $('#item_group-'+group_id).append(response.html);
                        }else{
                            getItems();
                        }
                    }
                    ShowToastOk();
                  } catch (err) { console.log(err);}
               
                //18-10-2021
            };
            initFormAjax('create_item','updateModal',callbackFunction);

        }
        
    })
}




function DeleteItems(element,hide=0){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    var id=$(element).attr('data-id');
    $.ajax(
        {
            type: "POST",
            url: '/items/ajx/delete',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        if(data.success) {
            //18-10-2021 
            //getItems();
            $('#item-'+id).remove();
            UpdateHoderRowGroup();
            //18-10-2021 
            if(hide){
                $('#updateModal').modal('hide');
            }
        }
    })
}

function ActiveItems(id){
    $.ajax(
        {
            type: "POST",
            url: '/items/ajx/active/'+id,
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        if(data.success) {
            getItems();
        }
    })
}



function getItemsList(scene_id){
    $.ajax({
        type: "POST",
        url: '/items/scenes/list',
        data:{
            scene_id:scene_id,
        },

    }
    )
    .done(function(data) {
        $('.sidebar .items_list').empty();
        if(data.success) {
            
            $('.sidebar .items_list').append(data.success);
            InitPopover();
        }
        InitPopover();
    });
}

function CreateBookItemsScenes(id_scene,show=false){

    $.ajax({
            type: "POST",
            url: '/items/scenes/form',
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
            $('#updateModal').modal('show');
            $('#updateModal .close' ).unbind("click");
            $('#updateModal .close' ).on( "click",function(){
                CloseModalForm('create_item_scene','updateModal',false);
            });
            initFormAjaxText('create_item_scene');

        }
        
    })
}

function DeleteItemsScenes(id_item,id_scenes){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    $.ajax({
        type: "POST",
        url: '/items/scenes/delete',
        data:{
            id_scenes:id_scenes,
            id_item:id_item,
        },

    }
    )
    .done(function(data) {
        if(data.success) {
            getItemsList(id_scenes);
        }

    });
}


function InitItemsGroups(){
    
    $('.filter_items_groups .groups-item input[type="checkbox"]').on('click', function (e) {
        //$('.aside__more.element .book').removeClass("active");
        $(this).parent().toggleClass('checked');
        getItems();
    });
    
}
//getLocationsGroupList
function getItemsGroupList(){
    $.ajax({
        type: "POST",
        url: '/items/groups/list',
        data:{
            scene_id:0,
        },

    }
    )
    .done(function(data) {
    if(data.success) {
        $('.sidebar .filter_items_groups').empty();
        $('.sidebar .filter_items_groups').append(data.success);
        InitItemsGroups();
    }
    });
}

//UpdateLocationGroup

function UpdateItemsGroup(id=0){

    $.ajax({
            type: "POST", 
            url: '/items/groups/form',
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
                getItemsGroupList();
                InitItemsGroups()
            
            };
            
            initFormAjax('update_item_group','updateModal',callbackFunction);
        
        
      
    })
}
//DeleteLocationGroup
function DeleteItemsGroup(id=0){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
    $.ajax({
            type: "POST", 
            url: '/items/groups/delete',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        getItemsGroupList();
        InitItemsGroups();
        getItems();
    })
}
//CreateLocationGroups
function CreateItemsGroups(id=0){

    $.ajax({
            type: "POST", 
            url: '/items/groups/form',
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
                getItems();
                getItemsGroupList();
                InitItemsGroups()
            
            };
            initFormAjax('create_item_group','updateModal',callbackFunction);
        
        
      
    })
}
function SelectOnlyThisItemGroup(search,element){
    element=$(element).parent().find('label');
    $('.'+search+' .groups-item label.checked').not(element).removeClass("checked");
    $(element).toggleClass("checked");
    getItems();
}


function ClearFilterItems(search,element){
    $('.'+search+' .groups-item label.checked').removeClass("checked");
    getItems();
}

function ClearBookItemsImage(element){
    var id=$(element).attr('data-id');
    if(id<=0){
        $(element).parent().find("[type=file]").val(''); 
        $(element).parent().parent().find(".preview-image").css("background","");
        return 0;
    }
    $.ajax({
            type: "POST", 
            url: '/items/clearimg',
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


function SaveItem(form,element){
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
                ShowToastOk();
                UpdateBookItems(false,data.element);
                getItemsGroupList();
                //18-10-2021
                //getItems(); 
                if(data.element>0){
                    $('#item-'+data.element).empty().append(data.html);
                }
                if(data.reload){
                    getItems();
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

function SaveItemAndAdd(form,element){
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
                CreateBookItems(1);
                getItemsGroupList();
                getItems();
            }
            ABTN(element,0);  
        })
        .fail(function () {
            ABTN(element,0);
        })
}