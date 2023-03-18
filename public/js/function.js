 
 // переключатель цвета сайта
 var book_id=0;
 var toast=0;

function setMainMenuMini(){
    if($.cookie('mini_main') != null){
        $('header.header').toggleClass('mini');
    }
    $('.border_menu').on('click', function (e) {
        var mini_main=$('header.header').hasClass("mini");
        if(!mini_main){
            $.cookie('mini_main', 'value', { expires: 7, path: '/' });
        }else{
            $.cookie('mini_main', 'value', { expires: -1, path: '/' });
        }
        $('header.header').toggleClass('mini');
    });
}


function setFilterMenuMini(){
    if($.cookie('mini_filter') != null){
        $('.sidebar.sidebar-left').toggleClass('mini');
    }
    $('.sidebar.sidebar-left .border_menu_filter').on('click', function (e) {
        var mini_main=$('.sidebar.sidebar-left').hasClass("mini");
        if(!mini_main){
            $.cookie('mini_filter', 'value', { expires: 7, path: '/' });
        }else{
            $.cookie('mini_filter', 'value', { expires: -1, path: '/' });
        }
        $('.sidebar.sidebar-left').toggleClass('mini');
    });
}

function setRightMenuMini(){
    if($.cookie('mini_menu_right') != null){
        $('.sidebar.sidebar-right').toggleClass('mini');
    }
    $('.sidebar.sidebar-right .border_menu_filter').on('click', function (e) {
        var mini_main=$('.sidebar.sidebar-right').hasClass("mini");
        if(!mini_main){
            $.cookie('mini_menu_right', 'value', { expires: 7, path: '/' });
        }else{
            $.cookie('mini_menu_right', 'value', { expires: -1, path: '/' });
        }
        $('.sidebar.sidebar-right').toggleClass('mini');
    });
}

function startDayCounWord(){
    getDayStat();
    setInterval(getDayStat,10000);
}

 jQuery(document).ready(function ($) {
    

    startDayCounWord();
    setMainMenuMini();
    setFilterMenuMini();
    setRightMenuMini();
    $('.theme-switcher').on('click', function (e) {
        e.stopPropagation()
        $('body').toggleClass('light-theme')
    });
    $('body').toggleClass('light-theme');

    $('#filter_book_name').keyup(function() {
        getBooks();
      });

    $('#filter_items_name').keyup(function() {
        getItems();
      });
      $('#filter_note_name').keyup(function() {
        noteGetNote();
      });


    $('#filter_locations_name').keyup(function() {
        getLocations();
      });


    $('#filter_pers_name').keyup(function() {
        getPers();
      });


    $('#filter_scenes_name').keyup(function() {
        getScenes();
      });


})


function readURL(input) {
    //console.log(input.files[0].size);
    if(input.files[0].size>999999){
        alert("Вы пытаетесь загрузить слишком большое изображение");
        return 0;
    }
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.preview-image').css('background',  'url('+e.target.result+')');
        };

        reader.readAsDataURL(input.files[0]);
    }
}




function UpdateHeader(book_id,book_name){
    return true;
}
var ask_save=[];
function CloseModalForm(element,modal,callback,save=1){
    var $ask=$('#askClose');
    $('#askClose').modal('hide');
        if(save){
            var $yiiform = $('#'+element);
            currentSelect2TagValue($yiiform);
            var formData = new FormData($yiiform[0]);
            // отправляем данные на сервер
            $.ajax({
                    type: $yiiform.attr('method'),
                    url: $yiiform.attr('action'),
                    data: formData,
                    dataType : 'text',
                    processData: false,
                    contentType: false,
                    cache: false,
                }
            )
            .done(function(data) {
                //ask_save_change=false;
                $(modal).attr('ask-save-element',false);
                ask_save[element].callback();
                //callback();
                
            })
            .fail(function () {
              
            })
        }
        $ask.one('hidden.bs.modal', function (event) {
            $(modal).modal('hide');
            console.log(modal);
          })
 
    
    //InitPopover();
}

function iniAskSave(element){
 
    $("#"+ask_save[element].modal).attr('ask-save-change',false);
}



function askSaveCloseOpen(element,modal,callback){//Открыть форму вопроса
    ask_save[element]={
        callback: callback,
        element: element,
        modal: modal,
    }
    $('#askClose').attr('ask-parent-modal-element',element);
    $('#askClose').modal('show');
}
function askSaveClose(){//Сохранить
    var ask_parent_modal_element=$('#askClose').attr('ask-parent-modal-element');
    CloseModalForm(ask_save[ask_parent_modal_element].element,$("#"+ask_save[ask_parent_modal_element].modal),ask_save[ask_parent_modal_element].callback,1);
    $('#'+ask_save[ask_parent_modal_element].modal).attr('ask-save-element',false);
    $('#'+ask_save[ask_parent_modal_element].modal).attr('ask-save-modal',false);
    $('#'+ask_save[ask_parent_modal_element].modal).attr('ask-save-callback',false);
    $('#'+ask_save[ask_parent_modal_element].modal).attr('ask-save-change',false);
    
}

function askSaveNoSaveClose(){//Закрыть не сохраняя
    var ask_parent_modal_element=$('#askClose').attr('ask-parent-modal-element');
    CloseModalForm(ask_save[ask_parent_modal_element].element,$("#"+ask_save[ask_parent_modal_element].modal),ask_save[ask_parent_modal_element].callback,0);
    $('#'+ask_save[ask_parent_modal_element].modal).attr('ask-save-element',false);
    $('#'+ask_save[ask_parent_modal_element].modal).attr('ask-save-modal',false);
    $('#'+ask_save[ask_parent_modal_element].modal).attr('ask-save-callback',false);
    $('#'+ask_save[ask_parent_modal_element].modal).attr('ask-save-change',false);
}

function askSaveCancel(){ //Кнопка отмена
    /*var ask_parent_modal_element=$('#askClose').attr('ask-parent-modal-element');

    $('#'+ask_save[ask_parent_modal_element].modal).attr('ask-save-element',false);
    $('#'+ask_save[ask_parent_modal_element].modal).attr('ask-save-modal',false);
    $('#'+ask_save[ask_parent_modal_element].modal).attr('ask-save-callback',false);
    $('#'+ask_save[ask_parent_modal_element].modal).attr('ask-save-change',false);*/
    $('#askClose').modal('hide');

}

function initFormAjax(element,modal,callback){
    
    $('input[type=file]').styler();
    $('#'+modal).attr('ask-save-element',false);
    $('#'+modal).attr('ask-save-modal',false);
    $('#'+modal).attr('ask-save-callback',false);
    $('#'+modal).attr('ask-save-change',false);

    $('#'+modal).on('hide.bs.modal', function(e){
        if(e.currentTarget==e.target){
        //Убераем все вложенные формы из обработки
            if($('#'+modal).attr('ask-save-change')=="true"){
                console.log($('#'+modal).attr('ask-save-change'));
                askSaveCloseOpen(element,modal,callback);
                e.preventDefault();
                e.stopImmediatePropagation();
                return false;
            }
        }
         
    });
    $('#'+modal+' input').keyup(function() {
        $('#'+modal).attr('ask-save-change',true);
    });
    $('#'+modal+' textarea').keyup(function() {
        $('#'+modal).attr('ask-save-change',true);
    });

    $('#'+modal+' #notes-text').on("summernote.change", function (e) {   // callback as jquery custom event 
        $('#'+modal).attr('ask-save-change',true);
    });

    $('#'+modal+' select').on('change',function() {
        $('#'+modal).attr('ask-save-change',true);
    });
    $('#'+modal+' .close' ).unbind("click");
    $('#'+modal+' .close' ).on( "click",function(){
        if($('#'+modal).attr('ask-save-change')=="true"){
            askSaveCloseOpen(element,modal,callback);
        }else{
            $('#'+modal).modal('hide');
        }

        
    });

    //$('textarea').autoresize();
    $('#'+element).off("onn");
    $('#'+element).on('afterValidate', function (e, messages, errorAttributes) {
        if(errorAttributes.length>0){
            
            ShowToastBad();
        }
    });
    $('#'+element).on('beforeSubmit', function () {
        ABTN($('#'+element).find(':submit'),1);
 

        var $yiiform = $(this);
        currentSelect2TagValue($yiiform);
        var formData = new FormData($yiiform[0]);
        // отправляем данные на сервер
       
        $.ajax({
                type: $yiiform.attr('method'),
                url: $yiiform.attr('action'),
                data: formData,
                dataType : 'text',
                processData: false,
                contentType: false,
                cache: false,
            }
        )
        .done(function(data) {
          
            console.log(data);
            $('#'+modal).attr('ask-save-change',false);
                $('#'+modal).modal('hide');
                
            callback(data);
            ABTN($('#'+element).find(':submit'),0);
        })
        .fail(function () {
            ABTN($('#'+element).find(':submit'),0);
        })
        
    return false; // отменяем отправку данных формы
    
    })
}

var massive_find=[];
function InitAt(scene_id){
    
    var massive=[];
   
    $.ajax({
        type: "POST",
        url: '/scenes/items/all',
        data:{
            scene_id:scene_id,
        },

    }
    )
    .done(function(data) {
        if(data.success) {

            $.each(data.result, function(i, item) {
                massive.push(item.name);
                massive_find.push(item);
            });
            
            $('#booktext-text').summernote('destroy');
            $("#booktext-text").summernote({
                maximumImageFileSize:200 * 1024,
                lang: 'ru-RU',
                tooltip:false,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['height', ['height']],
                    ['view', ['fullscreen']]
                  ],
                disableGrammar:false,
                tabDisable: false,
                height: $('.sidebar').height(),
                hint: {
                    mentions: massive,
                    match: /\B@(\w*)$/,
                    search: function (keyword, callback) {
                    callback($.grep(this.mentions, function (item) {
                        return item.indexOf(keyword) == 0;
                    }));
                    },
                    content: function (name) {
                        let someUsers = massive_find.filter(item => item.name === name);
                        TextAdd(someUsers,scene_id);
                        name=name.replace(/\([^()]*\)/g, '');
                        return name;

                    }    
                  }
              });
              $('[data-toggle=dropdown]').removeAttr('data-toggle').attr({'data-bs-toggle': 'dropdown'});
        
        }
    });
   
}
function TextAdd(TextAdd,scene_id){
    if(!TextAdd[0]) return 0;
    var element=TextAdd[0];
    $.ajax({
        type: "POST",
        url: '/scenes/items/add',
        data:{
            scene_id:scene_id,
            type:element.type,
            id:element.id
        },

    }
    )
    .done(function(data) {
        if(data.success) {
            
            getItemsList(scene_id);
            getLocationsScenesList(scene_id);
            getPersList(scene_id);
        }
    });
}
var id_target=0;
var type=0;
function getNotes(target="#this_notes"){
    var element=$(target)[0];
    if(element === undefined){
        return;
    }

    $.ajax({
        type: "POST",
        url: '/notes/index',
        data:{
            id_target:id_target,
            type:type,
        },

        }
    )
    .done(function(data) {
   

        if(data.success){
            $(target).empty();
            $(target).append(data.success);
           //$(target).removeAttr("data-simplebar");
           var t=SimpleBar.instances.get(element);
           if(t === undefined){
            new SimpleBar(element);
           }else{
            t.unMount();
            new SimpleBar(element);
           }
         
            InitPopover();
        }
       
    });
}

function CreateNoteModuleNote(element){

    var group_id=$(element).attr('data-group-id');
    $.ajax({
        type: "POST",
        url: '/notes/form',
        data:{
            type:1,
            id_target:id_target,
            group_id:group_id,
        },

        }
    )
    .done(function(data) {

        $('#noteModal .modal-dialog').empty();
        $('#noteModal .modal-dialog').append(data.success);
        $('#noteModal').modal('show');
        var callbackFunction=function(){
            try {

                getNoteGroupList();
                noteGetNote();
              } catch (err) {
              
                console.log(err);
              
              }
            
            getNotes();
        };
        initFormAjax('create_note','noteModal',callbackFunction);
        $('#notes-text').summernote('destroy');
        $("#notes-text").summernote({
            maximumImageFileSize:200 * 1024,
            lang: 'ru-RU',
            tooltip:false,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['height', ['height']],
                ['view', ['fullscreen']]
              ],
            disableGrammar:false,
            tabDisable: false,
            height: 400,
          });
          $('[data-toggle=dropdown]').removeAttr('data-toggle').attr({'data-bs-toggle': 'dropdown'});
        
    })
}

function CreateNote(){
    $.ajax({
        type: "POST",
        url: '/notes/form',
        data:{
            type:type,
            id_target:id_target,
        },

        }
    )
    .done(function(data) {

        $('#noteModal .modal-dialog').empty();
        $('#noteModal .modal-dialog').append(data.success);
        $('#noteModal').modal('show');
        var callbackFunction=function(){
            try {

                getNoteGroupList();
                noteGetNote();
              } catch (err) {
              
                console.log(err);
              
              }
            
            getNotes();
        };
        initFormAjax('create_note','noteModal',callbackFunction);
        $('#notes-text').summernote('destroy');
        $("#notes-text").summernote({
            maximumImageFileSize:200 * 1024,
            lang: 'ru-RU',
            tooltip:false,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['height', ['height']],
                ['view', ['fullscreen']]
              ],
            disableGrammar:false,
            tabDisable: false,
            height: 400,
          });
          $('[data-toggle=dropdown]').removeAttr('data-toggle').attr({'data-bs-toggle': 'dropdown'});
        
    })
}

function UpdateNote(element,id=false){
    if(!id){
        id=$(element).attr('data-id');
    }
    $.ajax({
        type: "POST",
        url: '/notes/form',
        data:{
            id:id,
        },

        }
    )
    .done(function(data) {

        $('#noteModal .modal-dialog').empty();
        $('#noteModal .modal-dialog').append(data.success);
        $('#noteModal').modal('show');
        var callbackFunction=function(){
            try {

                getNoteGroupList();
                noteGetNote();
                
              } catch (err) {
              
                console.log(err);
              
              }
            
            getNotes();
        };
        initFormAjax('update_note','noteModal',callbackFunction);
        $('#notes-text').summernote('destroy');
        $("#notes-text").summernote({
            maximumImageFileSize:200 * 1024,
            lang: 'ru-RU',
            tooltip:false,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['height', ['height']],
                ['view', ['fullscreen']]
              ],
            disableGrammar:false,
            tabDisable: false,
            height: 400,
          });
          $('[data-toggle=dropdown]').removeAttr('data-toggle').attr({'data-bs-toggle': 'dropdown'});
    })
}

function FavoriteNote(element){
    var id=$(element).attr('data-id');
    var favorite=$(element).hasClass("on");
    if(favorite){
        favorite=1;
    }else{
        favorite=0;
    }
    console.log(!favorite);
    $.ajax({
        type: "POST",
        url: '/notes/favorite',
        data:{
            id:id,
            favorite:favorite,
        },

        }
    )
    .done(function(data) {
        
        try {

            getNoteGroupList();
           
          } catch (err) {
          
            console.log(err);
          
          }
          try {

            noteGetNote();
           
          } catch (err) {
          
            console.log(err);
          
          }
          try {

            getScenesNote();

          } catch (err) {
          
            console.log(err);
          
          }
          try {

            getNotes();

          } catch (err) {
          
            console.log(err);
          
          }

    });

}



function InitPopover(){
    $('.group-card__info').off();
    $('.group-card__info').on('click', function (e) {
        $(this).toggleClass('fixed');
    });
    //return;
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    popoverTriggerList.map(function (popoverTriggerEl) {
        var is_set=bootstrap.Popover.getInstance(popoverTriggerEl);
        if(!is_set){
            new bootstrap.Popover(popoverTriggerEl,{
                trigger: 'focus'
           })
        }
    
    });
}

function GetActiveStory(){
    $.ajax({
        type: "POST",
        url: '/books/ajx/getactivestory',
        data:{
            id:0,
        },

        }
    )
    .done(function(data) {

        $('#updateModal .modal-dialog').empty();
        $('#updateModal .modal-dialog').append(data.success);
        $('#updateModal').modal('show');
        id_target=data.id;
        type=1;
        getNotes();
        initFormAjax('m_f_book','updateModal',nonefunction);
    })
}

function nonefunction(){return 1;}



function getScenesNote(type_this=false,id_target_this=false){
    var target=".notes";
    if(!type_this){
        type_this=type;
    }
    if(!id_target_this){
        id_target_this=id_target;
    }
    $.ajax({
        type: "POST",
        url: '/notes/index',
        data:{
            id_target:id_target_this,
            type:type_this,
            scenes_list:id_target,
        },

        }
    )
    .done(function(data) {
        if(data.success){
            $(target).empty();
            $(target).append(data.success);
            InitPopover();

        }
       
    });
}

function CreateNoteList(element){
    var type_this=$(element).attr('data-type');
    var id_target_this=$(element).attr('data-target');
    $.ajax({
        type: "POST",
        url: '/notes/form',
        data:{
            type:type_this,
            id_target:id_target_this
        },

        }
    )
    .done(function(data) {

        $('#noteModal .modal-dialog').empty();
        $('#noteModal .modal-dialog').append(data.success);
        $('#noteModal').modal('show');
        var funct=function(){
            getScenesNote(type_this,id_target_this)
        }
        initFormAjax('create_note','noteModal',funct);
        $('#notes-text').summernote('destroy');
        $("#notes-text").summernote({
            maximumImageFileSize:200 * 1024,
            lang: 'ru-RU',
            tooltip:false,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['height', ['height']],
                ['view', ['fullscreen']]
              ],
            disableGrammar:false,
            tabDisable: false,
            height: 400,
          });
          $('[data-toggle=dropdown]').removeAttr('data-toggle').attr({'data-bs-toggle': 'dropdown'});
        
    })
}

function UpdateNoteList(id){
    $.ajax({
        type: "POST",
        url: '/notes/form',
        data:{
            id:id,
        },

        }
    )
    .done(function(data) {

        $('.scens_note_open').empty();
        $('.scens_note_open').append(data.success);
        initFormAjax('update_note','noteModal',getScenesNote);
        $('#notes-text').summernote('destroy');
        $("#notes-text").summernote({
            maximumImageFileSize:200 * 1024,
            lang: 'ru-RU',
            tooltip:false,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['height', ['height']],
                ['view', ['fullscreen']]
              ],
            disableGrammar:false,
            tabDisable: false,
            height: 400,
          });
          $('[data-toggle=dropdown]').removeAttr('data-toggle').attr({'data-bs-toggle': 'dropdown'});
    })
}




function DeleteNote(id,type_i,id_target_i){
    var isAdmin = confirm("Это действие необратимо. Удалить объект?");
    if(!isAdmin)return 0;
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
            id_target=id_target_i;
            type=type_i;
            getNotes();
            getScenesNote();
        }
    });
}


function getDayStat(){
    try {
        $.ajax({
            type: "POST",
            url: '/stat/ajx/day',
            data:{
                id:0,
    
            },
    
            }
        )
        .done(function(data) {
            if(data.success>0){
                $("#book_count").text("За сегодня написано: "+data.success+" слов");
            }
            if(data.end_day){
                $('.rate .position-absolute.top-0').addClass("bg-danger");
                $('#rate').attr("title",data.end_day);
            }else{
                $('.rate .position-absolute.top-0').removeClass("bg-danger");
                $('#rate').attr("title","Нет уведомлений");
            }
            var exampleEl = document.getElementById('rate')
            var tooltip = new bootstrap.Tooltip(exampleEl, {
                boundary: document.body
            })
           
        });
    } catch (error) {
        
    }
    
}


function AddThroughNote(element){
    type=1
    id_target=$(element).attr('data-id');
    CreateNote();
}

function SaveNote(form,element){
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
                ShowToastOk();
                getNotes();
                getScenesNote();
                iniAskSave(form);
                UpdateNote(false,data.success);
            }else{
                ShowToastBad();
            }
            ABTN(element,0);
        })
        .fail(function () {
            ABTN(element,0);
        })
    
}

function SaveNoteAndAdd(form,element){
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
                CreateNote();
                getNotes();
                getScenesNote();
            }else{
                ShowToastBad($yiiform);
            }
            ABTN(element,0);
        })
        .fail(function () {
            ABTN(element,0);
        })
}

function AddNoteList(element){
    var type_this=$(element).attr('data-type');
    var id_target_this=$(element).attr('data-target');
    $.ajax({
            type: "POST",
            url: '/note/scenes/form',
            data:{
                id_scene: id_target_this,
                type: type_this,
            },

        }
    )
    .done(function(data) {
    
        $('#noteModal .modal-dialog').empty();
        $('#noteModal .modal-dialog').append(data.success);
     
            $('#noteModal').modal('show');
            var callbackFunction=function(){
                getScenesNote();
                InitPopover();
            };
            initFormAjax('create_note_scene','noteModal',callbackFunction);

     
        
    })
}





function currentSelect2TagValue(form){
    $(form).find(' .select2-hidden-accessible option').each(function(index,element){
        if($(element).attr("data-select2-tag")){
            $(element).attr("value","@"+$(element).val()); 
        }
    });
}

function OpenProfile(){
    $.ajax({
        type: "POST",
        url: '/profile/ajx/get',
        data:{
            id:0,
        },

        }
    )
    .done(function(data) {

        $('#updateModal .modal-dialog').empty();
        $('#updateModal .modal-dialog').append(data.success);
        $('#updateModal').modal('show');
        var func=function(){
            try {
                $('ul.main-menu .bi.bi-person-circle.profile').css("background-image",$('#update_user .preview-image.img-responsive').css("background-image"));
              } catch (err) {
              
                console.log(err);
              
              }
        };
        initFormAjax('update_user','updateModal',func);
    })
}

function TypeNoteSelect(element){
    element=$(element).parent().find('label');
    $('.filter_note_objects .groups-item label.checked').not(element).removeClass("checked");
    $(element).toggleClass("checked");
    noteGetNote();
}


function HideElementGroup(){
    return;
    var height=$(".group-list .group-list__row .add-group-item").outerHeight();
    $(".group-list .group-list__row ").each(function(index,element_row){
        var Items=$(element_row).children();
        Items.each(function() { 
            var ofset=$(element_row).offset().top+height;
            if($(this).offset().top > ofset){
                $(this).slideUp( false );
            }
        });
    })
    $(".group-list .accordion_row").outerHeight(height+150 );
}
function ShowGroup(element){
    var status=$(element).attr('data-bs-toggle');
    if(status=="false"){
        $(element).attr('data-bs-toggle','true');
        $(element).text("Свернуть все");
    }else{
        $(element).attr('data-bs-toggle','false');
        $(element).text("Показать все");
    }
    status=$(element).attr('data-bs-toggle');
    var height=$(".group-list .group-list__row .add-group-item").outerHeight();
    if(status=="false"){
        $(element).parent().find('.group-list__row').each(function(index,element_row){
        //18-10-2021
        var Items=$(element_row).children();
        Items.each(function() { 
            var ofset=$(element_row).offset().top+height;
  
            if($(this).offset().top > ofset){
                $(this).slideUp( false );
            }
                
            });
            //18-10-2021
        });
        $(element).parent().find(".accordion_row").outerHeight(height+100 );
        return;
    }
    $(element).parent().find('.group-list__row').each(function(index,element_row){
        //18-10-2021
        var Items=$(element_row).children();
        Items.each(function() { 
            var ofset=$(element_row).offset().top+height;
  
                $(this).slideDown(true);
            
        });
        //18-10-2021
    });
    $(element).parent().find(".accordion_row").outerHeight($(element).parent().find('.group-list__row').outerHeight()+100);
}

function UpdateHoderRowGroup(){
    return;
    $(".group-list .group-list__row .col").slideDown( true );
    var height=$(".group-list .group-list__row .add-group-item").outerHeight();
    $(".group-list .group-list__row ").each(function(index,element_row){
        var Items=$(element_row).children();
        Items.each(function() { 
            var ofset=$(element_row).offset().top+height;
            console.log($(this).offset().top , ofset);
            if($(this).offset().top > ofset){
                $(this).slideUp( false );
            }
        });
    })
    $(".group-list .accordion_row").outerHeight(height+150 );
}






function ClearUserImage(element){
    var token=$(element).attr('data-token');
    if(token<=0){
        $(element).parent().find("[type=file]").val(''); 
        $(element).parent().parent().find(".preview-image").css("background","");
        return 0;
    }
    $.ajax({
            type: "POST", 
            url: '/user/clearimg',
            data:{
                token:token,
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

function DownloadProfile(element){
    var OK = confirm("Это действие может занять несколько минут. Как архив будет готов мы отправим Вам сообщение на почту.");
    if(!OK)return 0;
    ABTN(element,1);

    $.ajax({
        type: "POST", 
        url: '/profile/download',
        data:{
            ok:OK,
        },

    })
    .done(function(data) {
   
        if(data.success>0){
            ABTN(element,0);
         
        }
    
        
    })
    
}

function OpenTariff(element){
    $.ajax({
        type: "POST", 
        url: '/tariff',
        data:{
            ok:1,
        },

    })
    .done(function(data) {
   
        if(data.success>0){
            $('#updateModal .modal-dialog').empty();
            $('#updateModal .modal-dialog').append(data.form);
            $('#updateModal').modal('show');
         
        }
    })
}

function PayTariff(coast,count){
    $.ajax({
        type: "POST", 
        url: '/tariff/pay',
        data:{
            coast:coast,
            count_day:count,
        },

    })
    .done(function(data) {
    
        if(data.success>0){
            window.location.href=data.url;
         
        }
    })
}

function SaveBook(form,element){
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
                try {
                    getBooksGroupList();
                    //18-10-2021
                    //getBooks(); 
                    if(data.reload){
                        getBooks();
                    }
                    if(data.element>0){
                        $('#book-'+data.element).empty().append(data.html);
                        console.log(data.element);
                        UpdateBook(element,data.element);
                    }
                    ask_save_change=false;
                    //18-10-2021
                } catch (error) {
                    
                }
                    
                    
            }else{
                ShowToastBad($yiiform);
            }
            ABTN(element,0);
        })
        .fail(function () {
            ABTN(element,0);
        })
    
}

function ClearBookImage(element){
    var id=$(element).attr('data-id');
    
    if(id<=0){
        $(element).parent().find("[type=file]").val(''); 
        $(element).parent().parent().find(".preview-image").css("background","");
        return 0;
    }

    $.ajax({
            type: "POST", 
            url: '/books/clearimg',
            data:{
                id:id,
            },

        }
    )
    .done(function(data) {
        if(data.success){
            getBooksGroupList();
                getBooks();
            $(element).parent().parent().find(".preview-image").css("background","");
        }
    })
}